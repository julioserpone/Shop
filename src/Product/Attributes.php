<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Product;

use Illuminate\Support\Collection;

class Attributes
{
	/**
	 * The requested attribute.
	 *
	 * @var mixed
	 */
	protected $attribute = null;

	/**
	 * Creates a new instance.
	 *
	 * @param  string $attr
	 *
	 * @return self
	 */
	public static function make(string $attr)
	{
		$attributes = new static;

		if (! method_exists($attributes, $attr)) {
			throw new \RuntimeException("The attribute {$attr} does not exist in the product object attributes");
		}

		$attributes->attribute = $attributes->$attr();

		return $attributes;
	}

	/**
	 * Returns the requested attribute keys.
	 *
	 * @return array
	 */
	public function keys() : array
	{
		return $this->attribute->keys()->all();
	}

	/**
	 * Returns the requested attribute values.
	 *
	 * @return array
	 */
	public function values() : array
	{
		return $this->attribute->values()->all();
	}

	/**
	 * Returns the requested attribute.
	 *
	 * @return Collection
	 */
	public function get() : Collection
	{
		return $this->attribute;
	}

	/**
	 * Returns the condition attribute schema.
	 *
	 * @return Collection
	 */
	protected function condition() : Collection
	{
		return Collection::make([
			'refurbished' => 'products.condition.refurbished',
			'used' => 'products.condition.used',
			'new' => 'products.condition.new',
		]);
	}

	/**
	 * Returns the type attribute schema.
	 *
	 * @return Collection
	 */
	public static function type()
	{
		return Collection::make([
			'item' => 'products.type.item'
		]);
	}
}
