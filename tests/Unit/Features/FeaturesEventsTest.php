<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Tests\Unit\Features;

use Antvel\Tests\TestCase;

use Antvel\Features\Models\Feature;
use Antvel\Product\Models\Product;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeaturesEventsTest extends TestCase
{
	use DatabaseTransactions;

	/** @test */
	function it_emits_an_event_if_the_name_was_changed()
	{
		// $this->usingMySql();

		// $feature = factory(Feature::class)->states('filterable')->create(['name' => 'color']);
		// factory(Product::class)->create(['name' => 'per', 'features' => '{"color": "red", "weight": "11"}']);
		// factory(Product::class)->create(['name' => 'per', 'features' => '{"color": "red", "weight": "11"}']);
		// factory(Product::class)->create(['name' => 'per', 'features' => '{"color": "green", "weight": "11"}']);

		// event($event = new \Antvel\Product\Events\ProductFeatureSaved($feature, 'foo'));
		// $listener = new \Antvel\Product\Listeners\UpdateFeatureName();
		// $listener->handle($event);

		// dd(
		// 	'- test -'
		// 	, $feature->fresh()->toArray()
		// 	, Product::pluck('features')->toArray()
		// );

		// $this->artisan('migrate:reset', ['--database' => self::TESTING_DB]);
	}
}
