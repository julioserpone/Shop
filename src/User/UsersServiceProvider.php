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

use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{
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
        $this->swapUserModel();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Swap the application user model with the one provided by Antvel.
     *
     * @return void
     */
    protected function swapUserModel()
    {
        if (! self::$userModelWasSwapped) {
            $this->app->make('config')->set('auth.providers.users.model', Models\User::class);
            self::$userModelWasSwapped = true;
        }
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
