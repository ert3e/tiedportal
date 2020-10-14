<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Sebwite\Support;


/**
 * This is the StubGenerator.
 *
 * @package        Sebwite\Support
 * @author         Sebwite Dev Team
 * @copyright      Copyright (c) 2015, Sebwite
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class StubGenerator
{
    /**
     * @var \Illuminate\View\Compilers\BladeCompiler
     */
    protected $compiler;

    protected $cachePath;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;


    /**
     * render
     *
     * @param       $string
     * @param array $vars
     *
     * @return string
     */
    public function render($string, array $vars = [ ])
    {
        $__tmp_stub_file = uniqid(time(), false);
        $__tmp_stub_path = path_join($this->getCachePath(), $__tmp_stub_file);
        $this->getFiles()->put($__tmp_stub_path, $this->getCompiler()->compileString($string));

        if ( is_array($vars) && !empty($vars) ) {
            extract($vars);
        }

        ob_start();
        include($__tmp_stub_path);
        $var = ob_get_contents();
        ob_end_clean();

        $this->getFiles()->delete($__tmp_stub_path);

        return $var;
    }

    /**
     * generate
     *
     * @param string $stubDir
     * @param string $destDir
     * @param array  $files
     * @param array  $vars
     *
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generate($stubDir, $destDir, array $files = [ ], array $vars = [ ])
    {
        foreach ( $files as $stubFile => $destFile ) {
            foreach ( array_dot($vars) as $key => $val ) {
                $destFile = Str::replace($destFile, '{' . $key . '}', $val);
            }

            $stubPath    = path_join($stubDir, $stubFile);
            $destPath    = path_join($destDir, $destFile);
            $destDirPath = path_get_directory($destPath);

            if ( !$this->getFiles()->exists($destDirPath) ) {
                $this->getFiles()->makeDirectory($destDirPath, 0755, true);
            }
            $rendered = $this->render($this->getFiles()->get($stubPath), $vars);
            $this->getFiles()->put($destPath, $rendered);
        }
        return $this;
    }

    /**
     * generateDirectoryStructure
     *
     * @param       $destDir
     * @param array $dirs
     *
     * @return $this
     */
    public function generateDirectoryStructure($destDir, array $dirs = [ ])
    {
        foreach ( $dirs as $dirPath ) {
            $dirPath = path_join($destDir, $dirPath);
            if ( !$this->getFiles()->exists($dirPath) ) {
                $this->getFiles()->makeDirectory($dirPath, 0755, true);
            }
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCachePath()
    {
        if ( !isset($this->cachePath) ) {
            $this->cachePath = storage_path('stubs');
        }
        if ( !$this->getFiles()->isDirectory($this->cachePath) ) {
            $this->getFiles()->makeDirectory($this->cachePath, 0755, true);
        }
        return $this->cachePath;
    }

    /**
     * Set the cachePath value
     *
     * @param mixed $cachePath
     *
     * @return StubGenerator
     */
    public function setCachePath($cachePath)
    {
        $this->cachePath = $cachePath;
        return $this;
    }

    /**
     * @return \Illuminate\View\Compilers\BladeCompiler
     */
    public function getCompiler()
    {
        if ( !isset($this->compiler) ) {
            $this->compiler = new \Illuminate\View\Compilers\BladeCompiler($this->getFiles(), $this->getCachePath());
        }
        return $this->compiler;
    }

    /**
     * getFiles method
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFiles()
    {
        if ( !isset($this->files) ) {
            $this->files = new \Illuminate\Filesystem\Filesystem();
        }
        return $this->files;
    }


}
