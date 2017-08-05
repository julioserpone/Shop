<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Tests\Unit\Categories;

use Mockery as m;
use Antvel\Tests\TestCase;
use Antvel\Contracts\CategoryRepositoryContract;
use Antvel\Categories\Repositories\CategoriesRepositoryCache;

class CategoriesRepositoryCacheTest extends TestCase
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

		$this->app->make(CategoriesRepositoryCache::class)->categoriesWithProducts();
	}

	/** @test */
	function it_can_cache_a_filter_for_a_given_list_categories_that_have_products_associated_with()
	{
		$mock = m::mock(CategoryRepositoryContract::class);
		$mock->shouldReceive('categoriesWithProducts')->once();

		$this->app->instance(CategoryRepositoryContract::class, $mock);

		$this->app->make(CategoriesRepositoryCache::class)->categoriesWithProducts([
			'name' => 'acc',
			'description' => 'ar',
		]);
	}

	/** @test */
	function it_can_cache_a_given_category_children()
	{
		$mock = m::mock(CategoryRepositoryContract::class);
		$mock->shouldReceive('childrenOf')->once();

		$this->app->instance(CategoryRepositoryContract::class, $mock);

		$this->app->make(CategoriesRepositoryCache::class)->childrenOf(1);
	}
}
