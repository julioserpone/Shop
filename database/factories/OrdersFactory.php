<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


use Antvel\User\Models\User;
use Faker\Generator as Faker;
use Antvel\Orders\Models\Order;
use Antvel\AddressBook\Models\Address;

$factory->define(Order::class, function (Faker $faker)
{
	return [
        'user_id' => function () { return factory(User::class)->create()->id;  },
        'seller_id' => function () { return factory(User::class)->states('seller')->create()->id; },
        'address_id' => function () { return factory(Address::class)->create()->id; },
        'status' => $faker->randomElement(['sent', 'cancelled', 'closed', 'open', 'paid', 'pending', 'received']),
        'type' => $faker->randomElement(['cart', 'wishlist', 'order', 'later']),
        'description' => $faker->text(150),
    ];
});
