<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Unit\Users;

use Carbon\Carbon;
use Epikfy\Tests\TestCase;
use Epikfy\Users\Models\User;

class UserTest extends TestCase
{
	/** @test */
	function a_user_can_enable_his_profile()
	{
		$user = factory(User::class)->create(['disabled_at' => Carbon::now()->subYear()]);

	 	$user->enable();

	 	$this->assertNull($user->fresh()->disabled_at);
	}

	/** @test */
	function a_user_can_disable_his_profile()
	{
		$user = factory(User::class)->create(['disabled_at' => null]);

	 	$user->disable();

	 	$this->assertNotNull($user->fresh()->disabled_at);
	}
}
