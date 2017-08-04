<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel;

use Illuminate\Support\ServiceProvider;

class AntvelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'antvel');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
        $this->registerMiddlewares();
        $this->registerServicesAliases();
    }

    /**
     * Register Antvel services in the container.
     *
     * @return void
     */
    protected function registerServices()
    {
        foreach (Antvel::bindings() as $key => $value) {
            is_numeric($key)
                ? $this->app->singleton($value)
                : $this->app->singleton($key, $value);
        }
    }

    /**
     * Register Antvel middlewares.
     *
     * @return void
     */
    protected function registerMiddlewares()
    {
        $this->app['router']->aliasMiddleware('managers', Http\Middleware\Managers::class);
    }

    /**
     * Register Antvel services aliases in the container.
     *
     * @return void
     */
    protected function registerServicesAliases()
    {
        foreach (Antvel::alias() as $key => $value) {
            $this->app->alias($value, $key);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Antvel::class];
    }
}
