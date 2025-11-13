<?php

namespace Arweave\Cli\Laravel;

use Arweave\Cli\ArweaveCli;
use Illuminate\Support\ServiceProvider;

class ArweaveServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/arweave.php', 'arweave'
        );

        $this->app->singleton(ArweaveCli::class, function ($app) {
            $config = $app['config']['arweave'];
            return new ArweaveCli(
                $config['protocol'],
                $config['host'],
                $config['port']
            );
        });

        $this->app->alias(ArweaveCli::class, 'arweave-cli');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/arweave.php' => config_path('arweave.php'),
        ], 'arweave-config');
    }
}
