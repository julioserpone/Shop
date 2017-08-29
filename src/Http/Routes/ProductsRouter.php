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

class ProductsRouter implements ComponentRouter
{
	/**
	 * Register the address book component routes in the given router.
	 *
	 * @param  Registrar $router
	 *
	 * @return void
	 */
	public function registrar(Registrar $router)
	{
		$router->group([

            'middleware' => ['web'],
            'namespace' => '\Product',

        ], function ($router) {

        	$router->resource('products', 'ProductsController');
            $router->get('productsSearch/', 'SearchController@index')->name('products.search'); ///////////////see if it can be move to search url

        });
	}
}
