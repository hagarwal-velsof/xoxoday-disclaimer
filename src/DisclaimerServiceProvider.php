<?php

namespace Xoxoday\Disclaimer;

use Illuminate\Support\ServiceProvider;

class DisclaimerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
   
    public function boot()
    {
        
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views','disclaimer');

        if ($this->app->runningInConsole()) {
            // Publish assets
            $this->publishes([
              __DIR__.'/resources/disclaimer_assets' => public_path('disclaimer_assets'),
            ], 'disclaimer_assets');
          
          }
    }

   
}
