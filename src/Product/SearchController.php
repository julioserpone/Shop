<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Product;

use Antvel\Http\Controller;
use Illuminate\Http\Request;
use Antvel\Categories\Categories;

class SearchController extends Controller
{
	/**
	 * The products repository.
	 *
	 * @var Products
	 */
	protected $products = null;

	/**
	 * The categories repository.
	 *
	 * @var Categories
	 */
	protected $categories = null;

    /**
     * Creates a new instance.
     *
     * @param Products $products
     *
     * @return void
     */
	public function __construct(Products $products, Categories $categories)
	{
		$this->products = $products;
		$this->categories = $categories;
	}

	/**
	 * Loads the products search.
	 *
	 * @return void
	 */
	public function index(Request $request)
	{
		//filter products by the given query.
		$response['products']['results'] = $this->products->filter([
			'search' => $request->get('q')
		], 4)->get();

		//filter categories by the given query.
		$response['products']['categories'] = $this->categories->havingProducts([
			'name' => $request->get('q'),
			'description' => $request->get('q'),
		], ['id', 'name'], 4);

		$response['products']['suggestions'] = Suggestions\Suggest::for('my_searches')->shake()->get('my_searches');

		$response['products']['categories_title'] = trans('globals.suggested_categories');
        $response['products']['suggestions_title'] = trans('globals.suggested_products');
        $response['products']['results_title'] = trans('globals.searchResults');

		return $response;
	}
}
