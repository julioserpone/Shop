<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Unit\Categories;

use Mockery as m;
use Epikfy\Tests\TestCase;
use Epikfy\Contracts\CategoryRepositoryContract;
use Epikfy\Categories\Repositories\CategoriesCacheRepository;

class CategoriesCacheRepositoryTest extends TestCase
{
	protected function tearDown()
	{
		m::close();
	}

	/** @test */
	function it_can_cache_a_list_of_categories_that_have_products_associated_with()
	{
		$mock = m::mock(CategoryRepositoryContract::class);
		$mock->shouldReceive('categoriesWithProducts')->once();
		$this->app->instance(CategoryRepositoryContract::class, $mock);

		$categories = $this->app->make(CategoriesCacheRepository::class)->categoriesWithProducts();

		$this->assertNull($categories); //need to come back here!
	}

	/** @test */
	function it_can_cache_a_filter_for_a_given_list_categories_that_have_products_associated_with()
	{
		$mock = m::mock(CategoryRepositoryContract::class);
		$mock->shouldReceive('categoriesWithProducts')->once();

		$this->app->instance(CategoryRepositoryContract::class, $mock);

		$categories = $this->app->make(CategoriesCacheRepository::class)->categoriesWithProducts([
			'name' => 'acc',
			'description' => 'ar',
		]);

		$this->assertNull($categories); //need to come back here!
	}

	/** @test */
	function it_can_cache_a_given_category_children()
	{
		$mock = m::mock(CategoryRepositoryContract::class);
		$mock->shouldReceive('childrenOf')->once();

		$this->app->instance(CategoryRepositoryContract::class, $mock);

		$categories = $this->app->make(CategoriesCacheRepository::class)->childrenOf(1);

		$this->assertNull($categories); //need to come back here!
	}
}
