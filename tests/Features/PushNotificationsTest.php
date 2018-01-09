<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Features;

use Epikfy\Tests\TestCase;
use Epikfy\Users\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class PushNotificationsTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->app->make('router')->resource('push', '\Epikfy\Users\Http\PushNotificationsController');
	}

	/** @test */
	function a_guest_is_not_allowed_to_see_user_notifications()
	{
		$response = $this->call('GET', 'push');

		$response->assertStatus(500);
	}

	/** @test */
	function it_retrieves_the_signed_user_push_notifications()
	{
		$user = factory(User::class)->create();
		$this->actingAs($user);

		factory(DatabaseNotification::class)->states('read')->create([
			'notifiable_id' => $user->id
		]);

		factory(DatabaseNotification::class)->states('unread')->create([
			'notifiable_id' => $user->id
		]);

		$response = $this->call('GET', 'push')->assertSuccessful();

		tap($response->json(), function ($data) {
			$this->assertCount(1, $data['read']);
			$this->assertCount(1, $data['unread']);
			$this->assertTrue(isset($data['read']));
			$this->assertTrue(isset($data['unread']));
		});
	}
}
