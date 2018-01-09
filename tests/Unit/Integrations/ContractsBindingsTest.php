<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Unit\Integrations;

use Epikfy\Tests\TestCase;
use Epikfy\Contracts\CategoryRepositoryContract;
use Epikfy\Contracts\FeaturesRepositoryContract;
use Epikfy\Features\Repositories\FeaturesRepository;
use Epikfy\Categories\Repositories\CategoriesRepository;

class ContractsBindingsTest extends TestCase
{
	/** @test */
	function it_returns_the_categories_repository_object_when_referring_to_its_contract()
	{
		$categoriesRepository = $this->app->make(CategoryRepositoryContract::class);

		$this->assertNotNull($categoriesRepository);
		$this->assertInstanceOf(CategoriesRepository::class, $categoriesRepository);
	}

	/** @test */
	function it_returns_the_features_repository_object_when_referring_to_its_contract()
	{
		$categoriesRepository = $this->app->make(FeaturesRepositoryContract::class);

		$this->assertNotNull($categoriesRepository);
		$this->assertInstanceOf(FeaturesRepository::class, $categoriesRepository);
	}
}
