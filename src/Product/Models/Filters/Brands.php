<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Product\Models\Filters;

use Illuminate\Database\Eloquent\Builder;

class Brands implements FilterContract
{
	/**
	 * The requested brand.
	 *
	 * @var int
	 */
	protected $brand = null;

	/**
     * Create a new instance.
     *
     * @param string $brand
     *
     * @return void
     */
	public function __construct(string $brand, Builder $builder)
	{
		$this->brand = $brand;
		$this->builder = $builder;
	}

	/**
	 * Builds the query with the given category.
	 *
	 * @return Builder
	 */
	public function query() : Builder
	{
		if (trim($brand = $this->brand) !== '') {
			$this->builder->where('brand', 'LIKE', $brand);
		}

		return $this->builder;
	}
}
