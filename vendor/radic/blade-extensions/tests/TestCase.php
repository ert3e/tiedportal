<?php namespace Radic\Tests\BladeExtensions;

use Sebwite\Testing\Laravel\Traits\ViewTester;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @inheritDoc
 */
abstract class TestCase extends \Sebwite\Testing\Laravel\AbstractTestCase
{
    use ViewTester;

    /** @inheritDoc */
    public function setUp()
    {
        parent::setUp();
        $this->app->config->set('blade_extensions.markdown.views', true);
        $this->app->config->set('blade_extensions.markdown.enabled', true);
        $this->app->config->set('blade_extensions.markdown.renderer', 'Radic\\BladeExtensions\\Renderers\\ParsedownRenderer');
    }

    /** @var array */
    public static $data;

    /**
     * @return DataGenerator
     */
    public static function getData()
    {
        if (! isset(static::$data)) {
            static::$data = new DataGenerator();
        }

        return static::$data;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory
     */
    public function view()
    {
        return $this->app[ 'view' ];
    }

    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected function getServiceProviderClass()
    {
        return 'Radic\BladeExtensions\BladeExtensionsServiceProvider';
    }

    protected function getPackageRootPath()
    {
        return realpath(__DIR__ . '/..');
    }

    /**
     * Adds assertion directives to blade and removes cached views
     */
    protected function loadViewTesting()
    {
        $this->addViewTesting(true, __DIR__ . '/views');
        $this->cleanViews();
    }
}
