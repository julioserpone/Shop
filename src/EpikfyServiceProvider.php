<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EpikfyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerResources();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
        $this->registerProviders();
        $this->registerServicesAliases();
    }

    /**
     * Register the Epikfy resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'epikfy');
    }

    /**
     * Register the Epikfy routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::namespace('Epikfy')->middleware('web')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * Register Epikfy services in the container.
     *
     * @return void
     */
    protected function registerServices()
    {
        foreach (Epikfy::bindings() as $key => $value) {
            is_numeric($key)
                ? $this->app->singleton($value)
                : $this->app->singleton($key, $value);
        }
    }

    /**
     * Register Epikfy services aliases in the container.
     *
     * @return void
     */
    protected function registerServicesAliases()
    {
        foreach (Epikfy::alias() as $key => $value) {
            $this->app->alias($value, $key);
        }
    }

    /**
     * Register Epikfy services providers.
     *
     * @return void
     */
    protected function registerProviders()
    {
        foreach (Epikfy::providers() as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Epikfy::class];
    }
}
