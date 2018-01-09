<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use Epikfy\Orders\Models\Order;
use Epikfy\Comments\Models\Comment;

$factory->define(Comment::class, function (Faker $faker) use ($factory)
{
    return [
        'commentable_id' => function () { return factory(Order::class)->create()->id; },
        'commentable_type' => Order::class,
        'id' =>  Uuid::uuid4()->toString(),
        'data' => ['message' => 'foo'],
        'read_at' => null,
    ];
});

$factory->state(Comment::class, 'unread', function ($faker) {
    return [
        'read_at' => null
    ];
});

$factory->state(Comment::class, 'read', function ($faker) {
    return [
        'read_at' => Carbon::now()
    ];
});
