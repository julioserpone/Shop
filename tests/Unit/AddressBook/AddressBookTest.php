<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Unit\AddressBook;

use Epikfy\Tests\TestCase;

class AddressBookTest extends TestCase
{
    /** @test */
    function an_address_belongs_to_a_user()
    {
        $user = factory('Epikfy\Users\Models\User')->create();
        $address = factory('Epikfy\AddressBook\Models\Address')->create(['user_id' => $user->id]);

        $this->assertInstanceOf('Epikfy\Users\Models\User', $address->user);
    }
}
