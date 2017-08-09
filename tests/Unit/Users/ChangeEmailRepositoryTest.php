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

use Carbon\Carbon;
use Antvel\Tests\Unit\Users\UsersTestCase;
use Antvel\User\Models\EmailChangePetition;
use Illuminate\Contracts\Auth\Authenticatable;

class ChangeEmailRepositoryTest extends UsersTestCase
{
	/**
	 * The testing petition.
	 *
	 * @var EmailChangePetition
	 */
	protected $petition = null;

	/**
	 * The users's repository.
	 *
	 * @var \Antvel\User\UsersRepository
	 */
	protected $repository = null;

	public function setUp()
	{
		parent::setUp();

		$this->petition = factory(EmailChangePetition::class)->create()->first();
		$this->repository =  $this->app->make('Antvel\User\ChangeEmailRepository');
	}

	public function test_a_repository_can_find_a_petition_base_of_a_given_constraints()
	{
		$petition = $this->repository->findBy([
            'new_email' => $this->petition->new_email,
            'user_id' => $this->petition->user_id,
            'confirmed' => '0',
        ])->first();

		$this->assertInstanceOf(Authenticatable::class, $this->petition->user);
		$this->assertEquals($petition->new_email, $this->petition->new_email);
		$this->assertInstanceOf(EmailChangePetition::class, $petition);
		$this->assertEquals($petition->token, $this->petition->token);
	}

	public function test_a_repository_can_create_email_petitions()
	{
		$user = $this->user();

		$request = [
			'request' => ['email'=>'gustavoocanto@gmail.com'],
            'old_email' => $user->email,
            'user_id' => $user->id,
		];

		$petition = $this->repository->create($request);

		$this->assertEquals($petition->new_email, 'gustavoocanto@gmail.com');
		$this->assertInstanceOf(Authenticatable::class, $petition->user);
		$this->assertInstanceOf(EmailChangePetition::class, $petition);
		$this->assertTrue($petition->expires_at->gt(Carbon::now()));
		$this->assertEquals($petition->old_email, $user->email);
		$this->assertEquals($petition->user_id, $user->id);
	}

	public function test_a_repository_can_refresh_email_petitions()
	{
		$petition = $this->repository->refresh(
			$this->petition
		);

		$this->assertInstanceOf(Authenticatable::class, $petition->user);
		$this->assertInstanceOf(EmailChangePetition::class, $petition);
		$this->assertTrue($petition->expires_at->gt(Carbon::now()));
		$this->assertFalse((bool) $petition->confirmed);
	}

	public function test_a_repository_can_confirm_email_petitions()
	{
		$petition = $this->repository->confirm(
			$this->petition->user_id, $this->petition->token, $this->petition->new_email
		);

		$this->assertTrue((bool) $petition->confirmed);
		$this->assertFalse(is_null($petition->expires_at));
	}

}
