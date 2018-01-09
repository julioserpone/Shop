<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Unit\Features;

use Mockery as m;
use Epikfy\Tests\TestCase;
use Epikfy\Contracts\FeaturesRepositoryContract;
use Epikfy\Features\Repositories\FeaturesCacheRepository;

class FeaturesCacheRepositoryTest extends TestCase
{
	protected function tearDown()
	{
		m::close();
	}

	/** @test */
	function it_exposes_the_features_allowed_to_be_in_the_products_filtering()
	{
		$mock = m::mock(FeaturesRepositoryContract::class);
		$mock->shouldReceive('filterable')->once();

		$this->app->instance(FeaturesRepositoryContract::class, $mock);

		$features = $this->app->make(FeaturesCacheRepository::class)->filterable();

		$this->assertNull($features);
	}

	/** @test */
	function it_returns_an_array_with_the_validation_rules_for_the_filterable_features()
	{
		$mock = m::mock(FeaturesRepositoryContract::class);
		$mock->shouldReceive('filterableValidationRules')->once();

		$this->app->instance(FeaturesRepositoryContract::class, $mock);

		$features = $this->app->make(FeaturesCacheRepository::class)->filterableValidationRules();

		$this->assertCount(0, $features);
	}
}
