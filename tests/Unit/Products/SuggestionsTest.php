<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Tests\Unit\Products;

use Antvel\Tests\TestCase;
use Antvel\Product\Models\Product;
use Antvel\Product\Suggestions\Suggest;

class SuggestionsTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->products = $this->createProducts();
	}

	protected function tagsToArray($tags)
	{
		return explode(',', $tags->implode(','));
	}

	protected function createProducts($tags = ['incidunt', 'qui', 'et', 'dolorem', 'id', 'ut'])
	{
		factory(Product::class, 16)->create();

		//We create 3 last new products to compare against and see if what is returned is correct.
		//These products have to be at the end in order for us to validate that suggestions do
		//not contain listed products
		foreach ($tags as $tag) {
			factory(Product::class)->create(['tags' => $tag]);
		}

		return Product::get();
	}

	/** @test */
	function it_always_returns_a_collection_object()
	{
		$this->signIn([
			'preferences' => '{"product_shared":"incidunt,et,qui"}'
		]);

		$suggestions = Suggest::for('product_shared')->shake();

		$this->assertInstanceOf('\Illuminate\Support\Collection', $suggestions);
	}

	/** @test */
	function it_suggests_products_based_on_user_preferences_for_a_given_key()
	{
		$user = factory('Antvel\User\Models\User')->make([
			'preferences' => '{"my_searches":"incidunt,et,qui"}'
		]);

		$listedProducts = $this->products->take(10);

		$suggestions = Suggest::for('my_searches')->actingAs($user)
			->excluding($listedProducts)
			->shake()
			->get('my_searches');

		$suggestionsTags = $this->tagsToArray(
			$suggestions->pluck('tags')
		);

		$foundProducts = $this->products->whereIn(
			'id', $suggestions->pluck('id')->all()
		);

		$this->assertTrue($foundProducts->count() <= 4);
		$this->assertCount(0, array_intersect(
			$foundProducts->pluck('id')->all(), $listedProducts->pluck('id')->all()
		));
	}

	/** @test */
	function it_suggests_products_based_on_signed_user_preferences_for_a_given_key()
	{
		$user = $this->signIn([
			'preferences' => '{"product_shared":"incidunt,et,qui"}'
		]);

		$listedProducts = $this->products->take(10);

		$suggestions = Suggest::for('my_searches')
			->excluding($listedProducts)
			->shake()
			->get('my_searches');

		$suggestionsTags = $this->tagsToArray(
			$suggestions->pluck('tags')
		);

		$foundProducts = $this->products->whereIn(
			'id', $suggestions->pluck('id')->all()
		);

		$this->assertTrue($foundProducts->count() <= 4);
		$this->assertCount(0, array_intersect(
			$foundProducts->pluck('id')->all(), $listedProducts->pluck('id')->all()
		));
	}

	/** @test */
	function it_completes_suggestion_with_random_for_a_given_key_if_the_limit_was_not_fulfill()
	{
		$user = $this->signIn([
			'preferences' => '{"product_viewed":"incidunt,et,qui"}'
		]);

		$suggestions = Suggest::for('product_viewed')->shake()->get('product_viewed');

		$this->assertCount(4, $suggestions);
	}

	/** @test */
	function it_is_able_to_suggest_for_a_list_of_given_keys()
	{
		$this->signIn([
			'preferences' => '{"product_shared":"dolorem,id,ut", "product_viewed":"incidunt,et,qui"}'
		]);

		$suggestions = Suggest::for('product_viewed', 'product_shared')->shake();

		$this->assertNotNull($suggestions->get('product_viewed'));
		$this->assertNotNull($suggestions->get('product_shared'));
		$this->assertCount(4, $suggestions->get('product_viewed'));
		$this->assertCount(4, $suggestions->get('product_shared'));
	}

	/** @test */
	function it_can_suggest_products_based_on_a_given_input()
	{
		$suggestions = Suggest::shakeFor($this->products->take(10));

		$this->assertInstanceOf('\Illuminate\Support\Collection', $suggestions);
		$this->assertCount(4, $suggestions);
	}
}
