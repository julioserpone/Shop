<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Tests\Unit\AddressBook;

use Antvel\Tests\TestCase;
use Antvel\User\Models\User;
use Antvel\AddressBook\Models\Address;

class AddressBookTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create()->first();
        $this->repository = $this->app->make('Antvel\AddressBook\AddressBook');
    }

    protected function validData(int $user_id = null)
    {
        return [
            'city' => 'Guacara',
            'zipcode' => '2001',
            'state' => 'Carabobo',
            'country' => 'Venezuela',
            'phone' => '+ 1 405 669 00 00',
            'name_contact' => 'Gustavo Ocanto',
            'user_id' => $user_id ?: $this->user->id,
            'line1' => 'Urb. Augusto Malave Villalba',
            'line2' => 'Conj#2, Piso#6, Apt#6-2, Los Azules',
        ];
    }

    /** @test */
    function it_has_the_correct_model()
    {
        $this->assertNotNull($this->repository->getModel());
        $this->assertInstanceOf(Address::class, $this->repository->getModel());
    }

    /** @test */
	public function the_given_user_must_has_2_addresses()
    {
        factory(Address::class)->create(['user_id' => 99]);
        factory(Address::class)->create(['user_id' => $this->user->id]);

    	$this->assertCount(1, $this->user->addresses);
        $this->assertInstanceOf(Address::class, $this->user->addresses->first());
    }

    /** @test */
    public function find_address_by_id()
    {
        $address = factory(Address::class)->create(['user_id' => $this->user->id])->first();
        factory(Address::class)->create();

        tap($this->repository->find($address->id)->first(), function($address) {
            $this->assertInstanceOf(Address::class, $address);
            $this->assertInstanceOf(User::class, $address->user);
            $this->assertSame($this->user->id, (int) $address->user_id);
        });
    }

    /** @test */
    public function create_a_new_address_for_a_signed_user()
    {
        $this->actingAs($this->user);

        tap($this->repository->create($this->validData())->fresh(), function($address) {
            $this->assertTrue($address->default);
            $this->assertCount(1, $this->user->addresses);
            $this->assertInstanceOf(Address::class, $address);
            $this->assertInstanceOf(User::class, $address->user);
            $this->assertTrue($this->user->id == $address->user_id);
        });
    }

    /** @test */
    public function create_a_new_address_for_a_given_user()
    {
        $user = factory(User::class)->create(['first_name' => 'Gustavo']);

        $address = $this->repository->for($user)->create(
            $this->validData()
        )->fresh();

        $this->assertTrue($address->default);
        $this->assertCount(1, $user->addresses);
        $this->assertInstanceOf(Address::class, $address);
        $this->assertTrue($user->id == $address->user_id);
        $this->assertInstanceOf(User::class, $address->user);
        $this->assertEquals('Gustavo', $address->user->first_name);
    }

    /** @test */
    function it_updates_an_address_for_the_given_signed_user()
    {
        $this->actingAs($this->user);
        $address = factory(Address::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->repository->update([
            'name_contact' => 'Gustavo Ocanto',
            'country' => 'Venezuela'
        ], $address);

        tap($address->fresh(), function($address) {
            $this->assertTrue($address->default);
            $this->assertCount(1, $this->user->addresses);
            $this->assertInstanceOf(Address::class, $address);
            $this->assertEquals('Venezuela', $address->country);
            $this->assertInstanceOf(User::class, $address->user);
            $this->assertTrue($this->user->id == $address->user_id);
            $this->assertEquals('Gustavo Ocanto', $address->name_contact);
        });
    }

    /** @test */
    function it_updates_an_address_for_the_given_user()
    {
        $address = factory(Address::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->repository->for($this->user)->update([
            'name_contact' => 'Gustavo Ocanto',
            'country' => 'Venezuela'
        ], $address);

        tap($address->fresh(), function($address) {
            $this->assertTrue($address->default);
            $this->assertCount(1, $this->user->addresses);
            $this->assertInstanceOf(Address::class, $address);
            $this->assertEquals('Venezuela', $address->country);
            $this->assertInstanceOf(User::class, $address->user);
            $this->assertTrue($this->user->id == $address->user_id);
            $this->assertEquals('Gustavo Ocanto', $address->name_contact);
        });
    }

    /** @test */
    function destroy_an_address_from_the_database()
    {
        $foo = factory(Address::class)->create(['user_id' => $this->user->id, 'name_contact' => 'foo']);
        factory(Address::class)->create(['user_id' => $this->user->id, 'name_contact' => 'bar']);

        $this->repository->destroy($foo);

        $this->assertTrue($foo->trashed());
        $this->assertCount(1, $this->user->addresses);
        $this->assertEquals('bar', $this->user->addresses->first()->name_contact);
    }

    /** @test */
    function set_a_given_address_to_default_for_a_signed_user()
    {
        $this->actingAs($this->user);
        $address_one = factory(Address::class)->create(['default' => false, 'user_id' => $this->user->id])->first();
        $address_two = factory(Address::class)->create(['default' => false, 'user_id' => $this->user->id])->first();

        $this->repository->update(['default' => true], $address_one);

        tap($this->user->fresh()->addresses, function ($addresses) {
            $this->assertTrue($addresses->first()->default);
            $this->assertFalse($addresses->last()->default);
        });
    }

    /** @test */
    function set_a_given_address_to_default_for_a_given_user()
    {
        $address_one = factory(Address::class)->create(['default' => false, 'user_id' => $this->user->id])->first();
        $address_two = factory(Address::class)->create(['default' => false, 'user_id' => $this->user->id])->first();

        $this->repository->for($this->user)->update(['default' => true], $address_one);

        tap($this->user->fresh()->addresses, function ($addresses) {
            $this->assertTrue($addresses->first()->default);
            $this->assertFalse($addresses->last()->default);
        });
    }

    /** @test */
    function reset_the_default_addresses_for_a_signed_user()
    {
        $this->actingAs($this->user);

        factory(Address::class)->create(['user_id' => $this->user->id, 'default' => true]);
        factory(Address::class)->create(['user_id' => $this->user->id, 'default' => false]);
        $another = factory(Address::class)->create(['default' => true]);

        $this->repository->resetDefaults();

        $addresses = Address::where('user_id', $this->user->id)->where('default', true)->get();

        $this->assertCount(0, $addresses);
        $this->assertTrue($another->default);
        $this->assertCount(2, $this->user->addresses);
    }

    /** @test */
    function reset_the_default_addresses_for_a_given_user()
    {
        factory(Address::class)->create(['user_id' => $this->user->id, 'default' => true]);
        factory(Address::class)->create(['user_id' => $this->user->id, 'default' => false]);
        $another = factory(Address::class)->create(['default' => true]);

        $this->repository->for($this->user)->resetDefaults();

        $addresses = Address::where('user_id', $this->user->id)->where('default', true)->get();

        $this->assertCount(0, $addresses);
        $this->assertTrue($another->default);
        $this->assertCount(2, $this->user->addresses);
    }

}
