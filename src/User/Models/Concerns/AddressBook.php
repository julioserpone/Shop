<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\User\Models\Concerns;

use Antvel\AddressBook\Models\Address;

trait AddressBook
{
	/**
     * An user has an address book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Create a new address for the given user.
     *
     * @param  array $attributes
     *
     * @return Address
     */
    public function newAddress($attributes)
    {
        $this->resetDefaultAddress();

        return $this->addresses()->create($attributes);
    }

    /**
     * Find an address for the given user.
     *
     * @param  array $attributes
     *
     * @return \Illuminate\Database\Eloquent\ModelNotFoundException|Address
     */
    public function findAddress($addressId)
    {
        return $this->addresses()->findOrFail($addressId);
    }

    /**
     * Reset the given user default address.
     *
     * @return void
     */
    public function resetDefaultAddress()
    {
        $this->addresses()->update(['default' => false]);
    }
}
