<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'fragments.page.header', 'App\Http\ViewComposers\PageHeaderComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
