<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Unit\Products;

use Epikfy\Tests\TestCase;
use Epikfy\Product\Attributes;

class AttributesTest extends TestCase
{
	/** @test */
	function it_retrieves_the_condition_attribute()
	{
		tap(Attributes::make('condition')->get(), function ($attr) {
			$this->assertArrayHasKey('refurbished', $attr);
			$this->assertArrayHasKey('used', $attr);
			$this->assertArrayHasKey('new', $attr);
		});
	}

	/** @test */
	function it_retrieves_the_type_attribute()
	{
		tap(Attributes::make('type')->get(), function ($attr) {
			$this->assertArrayHasKey('item', $attr);
		});
	}

	/** @test */
	function it_retrieves_the_type_attribute_keys()
	{
		tap(Attributes::make('type')->keys(), function ($values) {
			$this->assertTrue(is_array($values));
			$this->assertContains('item', $values);
		});
	}

	/** @test */
	function it_retrieves_the_type_attribute_values()
	{
		tap(Attributes::make('type')->values(), function ($values) {
			$this->assertContains('products.type.item', $values);
		});
	}

	/**
	 * @test
	 * @expectedException \RuntimeException
	 */
	function it_throws_an_exception_if_the_given_attribute_was_not_found()
	{
		$conditions = Attributes::make('foo')->keys();
	}

	/** @test */
	function it_returns_the_condition_attribute_keys()
	{
		tap(Attributes::make('condition')->keys(), function ($keys) {
			$this->assertTrue(is_array($keys));
			$this->assertContains('refurbished', $keys);
			$this->assertContains('used', $keys);
			$this->assertContains('new', $keys);
		});
	}

	/** @test */
	function it_returns_the_condition_attribute_values()
	{
		tap(Attributes::make('condition')->values(), function ($values) {
			$this->assertTrue(is_array($values));
			$this->assertContains('products.condition.refurbished', $values);
			$this->assertContains('products.condition.used', $values);
			$this->assertContains('products.condition.new', $values);
		});
	}
}
