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
use Epikfy\Users\Models\User;
use Epikfy\Users\Policies\UserPolicy;
use Illuminate\Contracts\Auth\Access\Gate;

class RegisterUserPoliciesTest extends TestCase
{
	public function setUp()
    {
    	parent::setUp();
    }

	/** @test */
	function it_is_able_to_register_the_Epikfy_user_policies_within_the_application()
	{
		$this->app->booted(function () {
			$policy = $this->app->make(Gate::class)->getPolicyFor(User::class);
			$this->assertInstanceOf(UserPolicy::class, $policy);
			$this->assertNotNull($policy);
    	});
	}
}
