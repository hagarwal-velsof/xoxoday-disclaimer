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
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');   
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views','xoform');

        if ($this->app->runningInConsole()) {
            // Publish assets
            $this->publishes([
              __DIR__.'/Database/Seeders/CodesSeeder.php' => database_path('Seeders/CodesSeeder.php'),
              __DIR__.'/resources/assets' => public_path('xoform_assets'),
              __DIR__.'/config/xoform.php' => config_path('xoform.php')
            ], 'xoform_assets');
          }
    }

   
}
