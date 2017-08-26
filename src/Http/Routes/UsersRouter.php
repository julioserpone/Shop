<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Http\Routes;

use Antvel\Contracts\ComponentRouter;
use Illuminate\Contracts\Routing\Registrar;

class UsersRouter implements ComponentRouter
{
	/**
	 * Register the user component routes in the given router.
	 *
	 * @param  Registrar $router
	 *
	 * @return void
	 */
	public function registrar(Registrar $router)
	{
		$router->group([

            'middleware' => ['web', 'auth'],
            'namespace' => '\User',

        ], function ($router) {

            $router->resource('user', 'UsersController');

            $router->resource('push', 'Http\PushNotificationsController');
            $router->resource('notifications', 'Http\NotificationsController');

            $router->get('user/products/listing', 'UsersProductsController@index')->name('users.products');

            $router->group([

                'middleware' => ['web', 'auth'],
                'prefix' => 'user/security'

            ], function ($router) {

                $router->get('confirmEmail/{token}/{email}', 'SecurityController@confirmEmail')->name('user.email');
                $router->patch('{action}/{user?}', 'SecurityController@update')->name('user.action');

            });

        });
	}
}
