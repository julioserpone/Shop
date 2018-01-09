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

use Epikfy\Tests\TestCase;
use Epikfy\Users\Models\User;
use Epikfy\AddressBook\Models\Address;
use Illuminate\Contracts\Auth\Authenticatable;

class UserAddressTest extends TestCase
{
	protected function validData($attributes = [])
    {
        return array_merge($attributes, [
            'city' => 'San Diego',
            'zipcode' => '2006',
            'state' => 'Carabobo',
            'country' => 'Venezuela',
            'phone' => '+ 1 405 669 00 00',
            'name_contact' => 'Julio Hernández',
            'line1' => 'Urbanizacion El Remanso',
            'line2' => 'Lote 22A Casa Número 4',
        ]);
    }

	/** @test */
	function an_user_has_addresses()
	{
	    $user = factory(User::class)->create();
	    factory(Address::class)->create(['user_id' => $user->id]);

	    $this->assertCount(1, $user->addresses);
	    $this->assertInstanceOf(Address::class, $user->addresses->first());
	}

	/** @test */
	function it_can_create_a_new_address()
	{
		$user = factory(User::class)->create();
		$address = $user->newAddress($this->validData());

		$this->assertInstanceOf(Address::class, $address);
		$this->assertEquals('San Diego', $address->city);
        $this->assertEquals('2006', $address->zipcode);
        $this->assertEquals('Carabobo', $address->state);
        $this->assertEquals('Venezuela', $address->country);
        $this->assertEquals('+ 58 424 432 38 83', $address->phone);
        $this->assertEquals('Julio Hernández', $address->name_contact);
        $this->assertSame($user->id, $address->user_id);
        $this->assertEquals('Urbanizacion El Remanso', $address->line1);
        $this->assertEquals('Lote 22A Casa Número 4', $address->line2);
        $this->assertTrue($address->fresh()->default);
	}

	/** @test */
	function there_can_be_just_one_default_adddress_per_user()
	{
	    $user = factory(User::class)->create();
	    factory(Address::class)->create(['user_id' => $user->id]);

	    $user->newAddress($this->validData());

		$this->assertCount(1, $user->fresh()->addresses->where('default', true));
	}

	/** @test */
	function it_can_find_a_given_address()
	{
	    $user = factory(User::class)->create();
		$address = factory(Address::class)->create(['user_id' => $user->id]);

		tap($user->findAddress($address->id), function ($address) use ($user) {
			$this->assertInstanceOf(Address::class, $address);
			$this->assertEquals($user->id, $address->user_id);
		});
	}

	/**
	 * @test
	 * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	function it_throws_an_exception_if_address_was_not_found()
	{
		$user = factory(User::class)->create();
		$address = factory(Address::class)->create();

		$address = $user->findAddress($address->id);
	}
}
