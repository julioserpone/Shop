<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\AddressBook;

use Antvel\Support\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Antvel\AddressBook\Models\Address;
use Illuminate\Contracts\Auth\Authenticatable;

class AddressBook extends Repository
{
	/**
	 * The user who owns the address.
	 *
	 * @var Authenticatable
	 */
	protected $user = null;

	/**
     * Creates a new instance.
     *
     * @param Address $category
     */
    public function __construct(Address $address)
    {
        $this->setModel($address);
    }

    /**
     * Set the user who owns the address.
     *
     * @param  Authenticatable $user
     *
     * @return self
     */
	public function for(Authenticatable $user)
	{
		$this->user = $user;

		return $this;
	}

	protected function user()
	{
		return is_null($this->user) ? Auth::user() : $this->user;
	}

	/**
     * Save a new model and return the instance.
     *
     * @param  array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes)
    {
		return Address::create([
			'user_id' => $this->user()->id,
            'name_contact' => $attributes['name_contact'],
            'phone' => $attributes['phone'],
            'country' => $attributes['country'],
            'state' => $attributes['state'],
            'city' => $attributes['city'],
            'zipcode' => $attributes['zipcode'],
            'line1' => $attributes['line1'],
            'line2' => $attributes['line2']
		]);
    }

    /**
     * Update a Model in the database.
     *
     * @param array $attributes
     * @param Category|mixed $idOrModel
     * @param array $options
     *
     * @return bool
     */
    public function update(array $attributes, $idOrModel, array $options = [])
    {
		$address = $this->modelOrFind($idOrModel);

		if (isset($attributes['default']) && $attributes['default']) {
			$this->resetDefaults();
		}

		return $address->update($attributes, $options);
    }

	/**
	 * Destroy the given address.
	 *
	 * @param int $id
	 *
	 * @return bool
	 */
	public function destroy($idOrModel)
	{
		$address = $this->modelOrFind($idOrModel);

		return $address->delete();
	}

	/**
	 * Reset the default addresses for a given user.
	 *
	 * @return void
	 */
	public function resetDefaults()
	{
		Address::where('user_id', $this->user()->id)
			->where('default', true)
			->update(['default' => false]);
	}
}
