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
use Epikfy\Features\Repositories\FeaturesRepository;
use Epikfy\Features\Repositories\FeaturesCacheRepository;
use Epikfy\Categories\Repositories\CategoriesRepository;
use Epikfy\Categories\Repositories\CategoriesCacheRepository;

class ContainerAliasesTest extends TestCase
{
	/** @test */
	function it_returns_category_repository_by_its_alias()
	{
		$categoriesRepository = $this->app->make('category.repository');
		$categoriesRepositoryCache = $this->app->make('category.repository.cahe');

		$this->assertNotNull($categoriesRepository);
		$this->assertNotNull($categoriesRepositoryCache);
		$this->assertInstanceOf(CategoriesRepository::class, $categoriesRepository);
		$this->assertInstanceOf(CategoriesCacheRepository::class, $categoriesRepositoryCache);
	}

	/** @test */
	function it_returns_features_repository_by_its_alias()
	{
		$featuresRepository = $this->app->make('product.features.repository');
		$featuresRepositoryCache = $this->app->make('product.features.repository.cahe');

		$this->assertNotNull($featuresRepository);
		$this->assertNotNull($featuresRepositoryCache);
		$this->assertInstanceOf(FeaturesRepository::class, $featuresRepository);
		$this->assertInstanceOf(FeaturesCacheRepository::class, $featuresRepositoryCache);
	}
}
