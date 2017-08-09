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

class DashboardRouter implements ComponentRouter
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

            'middleware' => ['web', 'auth', 'managers'],
            'prefix' => 'dashboard',

        ], function ($router) {

            $this->forHome($router);
            $this->forCategories($router);
            $this->forProductsFeatures($router);
            $this->forProducts($router);

        });
	}

	/**
	 * Registers the dashboard routes.
	 *
	 * @param  Registrar $router
	 *
	 * @return void
	 */
	protected function forHome($router)
	{
		$router->get('dashboard', 'Categories\CategoriesController@index')->name('dashboard.home');
        $router->get('/', 'Categories\CategoriesController@index')->name('dashboard.home');
	}

	/**
	 * Registers the dashboard categories routes.
	 *
	 * @param  Registrar $router
	 *
	 * @return void
	 */
	protected function forCategories($router)
	{
		$router->resource('categories', 'Categories\CategoriesController');
	}

	/**
	 * Registers the dashboard products features routes.
	 *
	 * @param  Registrar $router
	 *
	 * @return void
	 */
	protected function forProductsFeatures($router)
	{
		$router->resource('features', 'Features\FeaturesController');
	}

	/**
	 * Registers the dashboard products routes.
	 *
	 * @param  Registrar $router
	 *
	 * @return void
	 */
	protected function forProducts($router)
	{
		$router->resource('items', 'Product\Products2Controller');
        $router->get('items', 'Product\Products2Controller@indexDashboard')->name('items.index');
	}
}
