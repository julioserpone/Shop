<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Product\Repositories;

use Epikfy\Product\Models\Product;

class ProductsRepository
{
	/**
	 * It increments the given counter in the model.
	 *
	 * @param  string $field
	 * @param  Product $product
	 *
	 * @return void
	 */
	public function increment(string $field, Product $product)
	{
		$product->increment($field);
	}

	/**
	 * It decrements the given counter in the model.
	 *
	 * @param  string $field
	 * @param  Product $product
	 *
	 * @return void
	 */
	public function decrement(string $field, Product $product)
	{
		$product->decrement($field);
	}
}
