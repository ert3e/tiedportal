<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Sebwite\Support;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use ReflectionClass;

// SLP-14 Extra documenation for the new Sebwite\Support\ServiceProvider functionality

/**
 * Extends Laravel's base service provider with added functionality
 *
 * @author    Sebwite Dev Team
 * @copyright Copyright (c) 2015, Sebwite
 * @license   https://tldrlegal.com/license/mit-license MIT License
 * @package   Sebwite\Support
 * @property \Illuminate\Foundation\Application $app
 */
abstract class ServiceProvider extends BaseServiceProvider
{
    /**
     * Enables strict checking of provided bindings, aliases and singletons. Checks if the given items are correct. Set to false if
     *
     * @var bool
     */
    protected $strict = true;

    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The src directory path
     *
     * @var string
     */
    protected $dir;


    /*
     |---------------------------------------------------------------------
     | Resources properties
     |---------------------------------------------------------------------
     |
     */

    /**
     * Path to resources directory, relative to $dir
     *
     * @var string
     */
    protected $resourcesPath = '../resources';

    /**
     * Resource destination path, relative to base_path
     *
     * @var string
     */
    protected $resourcesDestinationPath = 'resources';


    /*
     |---------------------------------------------------------------------
     | Views properties
     |---------------------------------------------------------------------
     |
     */

    /**
     * View destination path, relative to base_path
     *
     * @var string
     */
    protected $viewsDestinationPath = 'resources/views/vendor/{namespace}';

    /**
     * Package views path
     *
     * @var string
     */
    protected $viewsPath = '{resourcesPath}/{dirName}';

    /**
     * A collection of directories in this package containing views.
     * ['dirName' => 'namespace']
     *
     * @var array
     */
    protected $viewDirs = [ /* 'dirName' => 'namespace' */ ];


    /*
     |---------------------------------------------------------------------
     | Assets properties
     |---------------------------------------------------------------------
     |
     */

    /**
     * Assets destination path, relative to public_path
     *
     * @var string
     */
    protected $assetsDestinationPath = 'vendor/{namespace}';

    /**
     * Package views path
     *
     * @var string
     */
    protected $assetsPath = '{resourcesPath}/{dirName}';

    /**
     * A collection of directories in this package containing assets.
     * ['dirName' => 'namespace']
     *
     * @var array
     */
    protected $assetDirs = [ /* 'dirName' => 'namespace' */ ];


    /*
     |---------------------------------------------------------------------
     | Configuration properties
     |---------------------------------------------------------------------
     |
     */

    /**
     * Collection of configuration files.
     *
     * @var array
     */
    protected $configFiles = [ ];

    /**
     * Path to the config directory, relative to $dir
     *
     * @var string
     */
    protected $configPath = '../config';

    protected $configStrategy = 'defaultConfigStrategy';

    /*
     |---------------------------------------------------------------------
     | Database properties
     |---------------------------------------------------------------------
     |
     */

    /**
     * Path to the migration destination directory, relative to database_path
     *
     * @var string
     */
    protected $migrationDestinationPath = 'migrations';

    /**
     * Path to the seeds destination directory, relative to database_path
     *
     * @var string
     */
    protected $seedsDestinationPath = 'seeds';

    /**
     * Path to database directory, relative to $dir
     *
     * @var string
     */
    protected $databasePath = '../database';

    /**
     * Array of directory names/paths relative to $databasePath containing seed files.
     *
     * @var array
     */
    protected $seedDirs = [ /* 'dirName', */ ];

    /**
     * Array of directory names/paths relative to $databasePath containing migration files.
     *
     * @var array
     */
    protected $migrationDirs = [ /* 'dirName', */ ];


    /*
     |---------------------------------------------------------------------
     | Miscellaneous properties
     |---------------------------------------------------------------------
     |
     */

    /**
     * Collection of service providers.
     *
     * @var array
     */
    protected $providers = [ ];

    /**
     * Collection of service providers that are deffered
     *
     * @var array
     */
    protected $deferredProviders = [ ];

    /**
     * Collection of classes to bind in the IOC container
     *
     * @var array
     */
    protected $bindings = [ ];

    /**
     * Collection of classes to register as singleton
     *
     * @var array
     */
    protected $singletons = [ ];

    /**
     * Collection of classes to register as share. Does not make an alias if the value is a class, as is the case with $shared.
     *
     * @var array
     */
    protected $share = [ ];

    /**
     * Collection of classes to register as share. Also registers an alias if the value is a class, as opposite to $share.
     *
     * @var array
     */
    protected $shared = [ ];

    /**
     * Wealkings are bindings that perform a bound check and will not override other bindings
     *
     * @var array
     */
    protected $weaklings = [ ];

    /**
     * Collection of aliases.
     *
     * @var array
     */
    protected $aliases = [ ];

    /**
     * Collection of middleware.
     *
     * @var array
     */
    protected $middleware = [ ];

    /**
     * Collection of prepend middleware.
     *
     * @var array
     */
    protected $prependMiddleware = [ ];

    /**
     * Collection of route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [ ];

    /**
     * Collection of bound instances.
     *
     * @var array
     */
    protected $provides = [ ];

    /**
     * Collection of commands.
     *
     * @var array
     */
    protected $commands = [ ];

    protected $commandPrefix = 'command.';

    /**
     * Collection of paths to search for commands
     * @var array
     */
    protected $findCommands = [ ];

    protected $findCommandsRecursive = false;

    protected $findCommandsExtending = 'Symfony\Component\Console\Command\Command';

    /**
     * @var array
     */
    protected $facades = [ /* 'Form' => Path\To\Facade::class */ ];

    /**
     * Collection of helper php files. To be included either on register or boot. Filepath is relative to $dir
     *
     * @var array
     */
    protected $helpers = [ /* $filePath => 'boot/register'  */ ];

    /**
     * Declaring the method named here will make it so it will be called on application booting
     *
     * @var string
     */
    protected $bootingMethod = 'booting';

    /**
     * Declaring the method named here will make it so it will be called when the application has booted
     *
     * @var string
     */
    protected $bootedMethod = 'booted';

    /*
     |---------------------------------------------------------------------
     | Booting functions
     |---------------------------------------------------------------------
     |
     */

    /**
     * Perform the booting of the service.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function boot()
    {
        $this->bootConfigFiles();
        $this->bootViews();
        $this->bootAssets();
        $this->bootMigrations();
        $this->bootSeeds();
        $this->requireHelpersFor('register');

        return $this->app;
    }

    /**
     * Adds the config files defined in $configFiles to the publish procedure.
     * Can be overriden to adjust default functionality
     */
    protected function bootConfigFiles()
    {
        if ( isset($this->dir) and isset($this->configFiles) and is_array($this->configFiles) ) {
            foreach ( $this->configFiles as $filename ) {
                $this->publishes([ $this->getConfigFilePath($filename) => config_path($filename . '.php') ], 'config');
            }
        }
    }

    /**
     * Adds the view directories defined in $viewDirs to the publish procedure.
     * Can be overriden to adjust default functionality
     */
    protected function bootViews()
    {
        if ( isset($this->dir) and isset($this->viewDirs) and is_array($this->viewDirs) ) {
            foreach ( $this->viewDirs as $dirName => $namespace ) {
                $viewPath             = $this->getViewsPath($dirName);
                $viewsDestinationPath = Str::replace($this->viewsDestinationPath, '{namespace}', $namespace);
                $this->loadViewsFrom($viewPath, $namespace);
                $this->publishes([ $viewPath => base_path($viewsDestinationPath) ], 'views');
            }
        }
    }

    /**
     * Adds the asset directories defined in $assetDirs to the publish procedure.
     * Can be overriden to adjust default functionality
     */
    protected function bootAssets()
    {
        if ( isset($this->dir) and isset($this->assetDirs) and is_array($this->assetDirs) ) {
            foreach ( $this->assetDirs as $dirName => $namespace ) {
                $assetDestinationPath = Str::replace($this->assetsDestinationPath, '{namespace}', $namespace);
                $this->publishes([ $this->getAssetsPath($dirName) => public_path($assetDestinationPath) ], 'public');
            }
        }
    }

    /**
     * Adds the migration directories defined in $migrationDirs to the publish procedure.
     * Can be overriden to adjust default functionality
     */
    protected function bootMigrations()
    {
        if ( isset($this->dir) and isset($this->migrationDirs) and is_array($this->migrationDirs) ) {
            foreach ( $this->migrationDirs as $dirPath ) {
                $this->publishes([ $this->getDatabasePath($dirPath) => database_path($this->migrationDestinationPath) ], 'migrations');
            }
        }
    }

    /**
     * Adds the seed directories defined in $seedDirs to the publish procedure.
     * Can be overriden to adjust default functionality
     */
    protected function bootSeeds()
    {
        if ( isset($this->dir) and isset($this->seedDirs) and is_array($this->seedDirs) ) {
            foreach ( $this->seedDirs as $dirPath ) {
                $this->publishes([ $this->getDatabasePath($dirPath) => database_path($this->seedsDestinationPath) ], 'migrations');
            }
        }
    }

    protected function requireHelpersFor($for)
    {
        foreach ( $this->helpers as $filePath => $on ) {
            if ( $on === $for ) {
                require_once Path::join($this->dir, $filePath);
            }
        }
    }

    /*
     |---------------------------------------------------------------------
     | Registration functions
     |---------------------------------------------------------------------
     |
     */

    /**
     * Registers the server in the container.
     *
     * @return \Illuminate\Foundation\Application
     * @throws \Exception
     */
    public function register()
    {
        $this->viewsPath  = Str::replace($this->viewsPath, '{resourcesPath}', $this->getResourcesPath());
        $this->assetsPath = Str::replace($this->assetsPath, '{resourcesPath}', $this->getResourcesPath());

        // FIRST register all given providers
        foreach ( $this->providers as $provider ) {
            $this->app->register($provider);
        }

        foreach ( $this->deferredProviders as $provider ) {
            $this->app->registerDeferredProvider($provider);
        }

        if(method_exists($this, $this->bootingMethod)){
            $this->app->booting(function(Application $app){
                $app->call([$this, $this->bootingMethod]);
            });
        }

        if(method_exists($this, $this->bootedMethod)){
            $this->app->booted(function(Application $app){
                $app->call([$this, $this->bootedMethod]);
            });
        }

        // Config
        $this->registerConfigFiles();

        // Middlewares
        if ( !$this->app->runningInConsole() ) {
            $router = $this->app->make('router');
            $kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');

            foreach ( $this->prependMiddleware as $middleware ) {
                $kernel->prependMiddleware($middleware);
            }

            foreach ( $this->middleware as $middleware ) {
                $kernel->pushMiddleware($middleware);
            }

            foreach ( $this->routeMiddleware as $key => $middleware ) {
                $router->middleware($key, $middleware);
            }
        }

        // Container bindings and aliases
        foreach ( $this->bindings as $binding => $class ) {
            $this->app->bind($binding, $class);
        }

        foreach ( $this->weaklings as $binding => $class ) {
            $this->bindIf($binding, $class);
        }

        foreach ( [ 'share' => $this->share, 'shared' => $this->shared ] as $type => $bindings ) {
            foreach ( $bindings as $binding => $class ) {
                $this->share($binding, $class, [ ], $type === 'shared');
            }
        }

        foreach ( $this->singletons as $binding => $class ) {
            if ( $this->strict && !class_exists($class) && !interface_exists($class) ) {
                throw new \Exception(get_called_class() . ": Could not find alias class [{$class}]. This exception is only thrown when \$strict checking is enabled");
            }
            $this->app->singleton($binding, $class);
        }

        foreach ( $this->aliases as $alias => $full ) {
            if ( $this->strict && !class_exists($full) && !interface_exists($full) ) {
                throw new \Exception(get_called_class() . ": Could not find alias class [{$full}]. This exception is only thrown when \$strict checking is enabled");
            }
            $this->app->alias($alias, $full);
        }


        // Commands
        if ( $this->app->runningInConsole() ) {
            foreach ( $this->findCommands as $path ) {
                $dir     = path_get_directory((new ReflectionClass(get_called_class()))->getFileName());
                $classes = $this->findCommandsIn(path_join($dir, $path), $this->findCommandsRecursive);

                $this->commands = array_merge($this->commands, $classes);
            }
            if ( is_array($this->commands) and count($this->commands) > 0 ) {
                $commands = [ ];
                foreach ( $this->commands as $k => $v ) {
                    if ( is_string($k) ) {
                        $this->app[ $this->commandPrefix . $k ] = $this->app->share(function ($app) use ($k, $v) {
                            return $app->build($v);
                        });

                        $commands[] = $this->commandPrefix . $k;
                    } else {
                        $commands[] = $v;
                    }
                }
                $this->commands($commands);
            }
        }
        // Facades
        if ( class_exists('Illuminate\Foundation\AliasLoader') ) {
            \Illuminate\Foundation\AliasLoader::getInstance($this->facades)->register();
        }

        // Helpers
        $this->requireHelpersFor('register');

        return $this->app;
    }

    /**
     * The default config merge function, instead of using the laravel mergeConfigRom it
     *
     * @param $path
     * @param $key
     */
    protected function defaultConfigStrategy($path, $key)
    {
        $config = $this->app->make('config')->get($key, [ ]);
        $this->app->make('config')->set($key, array_replace_recursive(require $path, $config));
    }

    /**
     * Merges all defined config files defined in $configFiles.
     * Can be overriden to adjust default functionality
     */
    protected function registerConfigFiles()
    {
        if ( isset($this->dir) and isset($this->configFiles) and is_array($this->configFiles) ) {
            foreach ( $this->configFiles as $key ) {
                $path = $this->getConfigFilePath($key);
                call_user_func_array([ $this, $this->configStrategy ], [ $path, $key ]);
            }
        }
    }

    public function findCommandsIn($path, $recursive = false)
    {
        $classes = [ ];
        foreach ( $this->findCommandsFiles($path) as $filePath ) {
            $class = Util::getClassNameFromFile($filePath);
            if ( $class !== null ) {
                $namespace = Util::getNamespaceFromFile($filePath);
                if ( $namespace !== null ) {
                    $class = "$namespace\\$class";
                }
                $class = Str::removeLeft($class, '\\');
                $parents = class_parents($class);
                if(isset($this->findCommandsExtending) && in_array($this->findCommandsExtending, $parents, true) === false){
                    continue;
                }
                $classes[] = Str::removeLeft($class, '\\');
            }
        }
        return $classes;
    }

    public function findCommandsFiles($directory)
    {
        $glob = glob($directory . '/*');

        if ( $glob === false ) {
            return [ ];
        }

        // To get the appropriate files, we'll simply glob the directory and filter
        // out any "files" that are not truly files so we do not end up with any
        // directories in our list, but only true files within the directory.
        return array_filter($glob, function ($file) {
            return filetype($file) == 'file';
        });
    }



    /**
     * Push a Middleware on to the stack
     *
     * @param $middleware
     *
     * @return mixed
     */
    protected function pushMiddleware($middleware, $force = false)
    {
        if ( $this->app->runningInConsole() && $force === false ) {
            return;
        }
        return $this->app[ 'Illuminate\Contracts\Http\Kernel' ]->pushMiddleware($middleware);
    }

    /**
     * Prepend a Middleware in the stack
     *
     * @param $middleware
     *
     * @return mixed
     */
    protected function prependMiddleware($middleware, $force = false)
    {
        if ( $this->app->runningInConsole() && $force === false ) {
            return;
        }
        return $this->app[ 'Illuminate\Contracts\Http\Kernel' ]->prependMiddleware($middleware);
    }

    /**
     * Add a route middleware. Will not be added when running in console.
     *
     * @param      $key
     * @param null $middleware
     *
     * @param bool $force
     *
     * @return mixed
     */
    protected function routeMiddleware($key, $middleware = null, $force = false)
    {
        if ( $this->app->runningInConsole() && $force === false ) {
            return;
        }
        if ( is_array($key) ) {
            foreach ( $key as $k => $m ) {
                $this->routeMiddleware($k, $m);
            }
        } else {
            return $this->app[ 'router' ]->middleware($key, $middleware);
        }
    }

    /**
     * Registers a binding if it hasn't already been registered.
     *
     * @param  string               $abstract
     * @param  \Closure|string|null $concrete
     * @param  bool                 $shared
     * @param  bool|string|null     $alias
     *
     * @return void
     */
    protected function bindIf($abstract, $concrete = null, $shared = true, $alias = null)
    {
        if ( !$this->app->bound($abstract) ) {
            $concrete = $concrete ?: $abstract;

            $this->app->bind($abstract, $concrete, $shared);
        }
    }

    /**
     * Register a class so it's shared. Optionally create an alias for it.
     *
     * @param       $binding
     * @param       $class
     * @param array $params
     * @param bool  $alias
     */
    protected function share($binding, $class, $params = [ ], $alias = false)
    {
        if ( is_string($class) ) {
            $closure = function ($app) use ($class, $params) {
                return $app->build($class, $params);
            };
        } else {
            $closure = $class;
        }
        $this->app[ $binding ] = $this->app->share($closure);
        if ( $alias ) {
            $this->app->alias($binding, $class);
        }
    }


    /*
     |---------------------------------------------------------------------
     | Path getter convinience functions
     |---------------------------------------------------------------------
     |
     */

    /**
     * getFilePath
     *
     * @param        $relativePath
     * @param null   $fileName
     * @param string $ext
     *
     * @return string
     */
    public function getPath($relativePath, $fileName = null, $ext = '.php')
    {
        $path = Path::join($this->dir, $relativePath);

        return is_null($fileName) ? $path : Path::join($path, $fileName . $ext);
    }

    /**
     * getConfigFilePath
     *
     * @param null $fileName
     *
     * @return string
     */
    public function getConfigFilePath($fileName = null)
    {
        return $this->getPath($this->configPath, $fileName);
    }

    /**
     * getMigrationFilePath
     *
     * @param null $path
     *
     * @return string
     */
    public function getDatabasePath($path = null)
    {
        return $this->getPath($this->databasePath, $path, '');
    }

    /**
     * getViewFilePath
     *
     * @param null $path
     *
     * @return string
     */
    public function getResourcesPath($path = null)
    {
        return $this->getPath($this->resourcesPath, $path, '');
    }

    /**
     * getAssetsPath
     *
     * @param null $dirName
     *
     * @return string
     */
    public function getAssetsPath($dirName)
    {
        return Str::replace($this->assetsPath, '{dirName}', $dirName);
    }

    /**
     * getViewsPath
     *
     * @param null $path
     *
     * @return string
     */
    public function getViewsPath($dirName)
    {
        return Str::replace($this->viewsPath, '{dirName}', $dirName);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        $provides = $this->provides;

        foreach ( $this->providers as $provider ) {
            $instance = $this->app->resolveProviderClass($provider);

            $provides = array_merge($provides, $instance->provides());
        }

        $commands = [];
        foreach($this->commands as $k => $v){
            if(is_string($k)){
                $commands[] = $k;
            }
        }

        return array_merge(
            $provides,
            array_keys($this->aliases),
            array_keys($this->bindings),
            array_keys($this->share),
            array_keys($this->shared),
            array_keys($this->singletons),
            array_keys($this->weaklings),
            $commands
        );
    }
}
