<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;

class UsersServiceProvider extends ServiceProvider
{
    use Events\EventMap,
        Policies\PolicyMap;

    /**
     * Check whether the user model was swapped.
     *
     * @var boolean
     */
    protected static $userModelWasSwapped = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerEvents();
        $this->registerPolicies();
        $this->registerUserModel();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMiddlewares();
    }

    /**
     * Register the User Antvel events.
     *
     * @return void
     */
    protected function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * Register the antvel policies.
     *
     * @return void
     */
    protected function registerPolicies()
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    /**
     * Swap the application user model with the one provided by Antvel.
     *
     * @return void
     */
    protected function registerUserModel()
    {
        if (! self::$userModelWasSwapped) {
            $this->app->make('config')->set('auth.providers.users.model', Models\User::class);
            self::$userModelWasSwapped = true;
        }
    }

    /**
     * Register Antvel middlewares for user policies.
     *
     * @return void
     */
    protected function registerMiddlewares()
    {
        $this->app->make('router')->aliasMiddleware('managers', Http\Middleware\Managers::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['antvel-users'];
    }
}
