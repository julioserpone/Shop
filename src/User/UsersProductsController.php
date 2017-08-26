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

use Antvel\Http\Controller;
use Antvel\Product\Products;
use Illuminate\Http\Request;

class UsersProductsController extends Controller //see if needs to be deleted!
{
	protected $products = null;

	//temporary while refactoring.
	protected $panel = [
    	'center' => ['width' => '10'],
    	'left' => ['width' => '2'],
	];

	public function __construct(Products $products)
	{
		$this->products = $products;
	}

	/**
	 * List the logged in user products.
	 *
	 * @param  Request $request
	 *
	 * @return void
	 */
    public function index(Request $request)
    {
    	return view('user.myProducts', [
    		'products' => $this->products->filter($request->all())->paginate(20),
    		'filter' => $request->get('filter'),
    		'panel' => $this->panel,
    	]);
    }
}
