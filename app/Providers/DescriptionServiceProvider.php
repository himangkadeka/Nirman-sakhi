<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\ContentService;

class DescriptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('get_description', function ($app) {
            return new ContentService();
        });
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
