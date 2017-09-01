<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Tests\Unit\Users;

use Antvel\User\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UsersRepositoryTest extends UsersTestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->user = $this->user();
		$this->repository =  $this->getRepo();
	}

	public function test_a_repository_can_retrieve_a_signed_user()
	{
		$this->actingAs($this->user);
		$profile = $this->repository->user();

		$this->assertEquals($this->user->id, $profile->id);
		$this->assertInstanceOf(Authenticatable::class, $profile);
	}

	public function test_a_repository_can_check_whether_a_user_is_signed_in()
	{
		$this->actingAs($this->user);

		$this->assertTrue($this->repository->isLoggedIn());
	}

	public function test_a_repository_can_find_users_in_the_database()
	{
		$user = $this->repository->find(
			$this->user->id
		);

		$this->assertInstanceOf(Authenticatable::class, $user);
		$this->assertEquals($user->id, $this->user->id);
	}

	public function test_a_repository_can_show_a_user_profile()
	{
		$profile = $this->repository->profile(
			$this->user->id
		);

		$this->assertInstanceOf(Authenticatable::class, $profile);
		$this->assertEquals($this->user->id, $profile->id);
		$this->assertTrue($profile->count() > 0);
	}

	public function test_a_repository_is_able_to_update_a_user_profile()
	{
		$this->repository->update($this->user, [
			'first_name' => 'Gustavo',
			'last_name' => 'Ocanto',
			'nickname' => 'gocanto',
		]);

		$newPerson = $this->repository->profile($this->user->id);

		$this->assertEquals($newPerson->fullName, 'Gustavo Ocanto');
		$this->assertEquals($newPerson->nickname, 'gocanto');
	}

	public function test_a_repository_is_able_to_create_a_user_profile()
	{
		$user = $this->repository->create([
            'first_name' => 'Gustavo',
            'last_name'  => 'Ocanto',
            'nickname' => 'gocanto',
            'email' => 'gustavoocanto@gmail.com',
            'password' => '123456',
            'role' => 'customer',
        ]);

		$this->assertInstanceOf(Authenticatable::class, $user);
        $this->assertEquals($user->email, 'gustavoocanto@gmail.com');
        $this->assertEquals($user->fullName, 'Gustavo Ocanto');

		$this->assertTrue(
			$this->app->make('hash')->check('123456', $user->password)
		);
	}

	public function test_a_repository_is_able_to_update_the_user_password()
	{
		$this->repository->update($this->user, [
			'password' => '123456',
		]);

		$hash = $this->app->make('hash');

		$newPerson = $this->repository->profile($this->user->id);

		$this->assertTrue(
			$hash->check('123456', $newPerson->password)
		);
	}

	public function test_a_repository_can_enable_users()
	{
		$this->repository->enable($this->user->id);

		$this->assertNull($this->user->disabled_at);
	}

	public function test_a_repository_can_disable_users()
	{
		$this->repository->disable($this->user->id);

		$this->assertNull($this->user->disabled_at);
	}

	/** @test */
	function it_is_able_to_update_the_signed_in_user_preferences_for_a_given_key()
	{
		$user = $this->signIn([
			'preferences' => '{"my_searches": "aa", "product_shared": "bb", "product_viewed": "cc", "product_purchased": "dd", "product_categories": "99"}'
		]);

		factory('Antvel\Product\Models\Product')->create(['tags' => 'foo']);
		factory('Antvel\Product\Models\Product')->create(['tags' => 'bar']);

		$products = \Antvel\Product\Models\Product::get();
		$user->updatePreferences('my_searches', $products);

		tap($user->fresh()->preferences, function ($preferences) use ($products) {
			$this->assertEquals('foo,bar,aa', $preferences['my_searches']);
			$this->assertEquals($preferences['product_shared'], 'bb');
			$this->assertEquals($preferences['product_viewed'], 'cc');
			$this->assertEquals($preferences['product_purchased'], 'dd');
			$this->assertEquals($preferences['product_categories'], '99,' . $products->pluck('category_id')->implode(','));
		});
	}
}
