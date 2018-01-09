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
use Faker\Generator as Faker;
use Epikfy\Companies\Models\Company;

$factory->define(Company::class, function (Faker $faker) use ($factory)
{
    return [
        //Profile information
        'name' => 'Epikfy e-commerce',
        'description' => 'Laravel e-commerce solution.',
        'email' => $faker->unique()->safeEmail,
        'logo' => '/images/pt-default/' . $faker->unique()->numberBetween(1, 330) . '.jpg',
        'slogan' => $faker->catchPhrase,
        'status' => true,
        'default' => false,

        //Contact information
        'contact_email' => $faker->unique()->safeEmail,
        'sales_email' => $faker->unique()->safeEmail,
        'support_email' => $faker->unique()->safeEmail,
        'phone_number' => $faker->e164PhoneNumber,
        'cell_phone' => $faker->e164PhoneNumber,
        'address' => $faker->streetAddress,
        'state' => $faker->state,
        'city' => $faker->city,
        'zip_code' => $faker->postcode,

        //Social information
        'website' => 'http://www.epikfy.com',
        'twitter' => 'https://twitter.com/epikfy',
        'facebook' => 'https://www.facebook.com/epikfy',

        //SEO information
        'keywords' => implode(',', $faker->words(20)),

        //CMS information
        'about' => $faker->text(500),
        'terms' => $faker->text(500),
        'refunds' => $faker->text(500),
    ];
});

$factory->state(Company::class, 'default', function ($faker) {
    return [
        'name' => 'Epikfy e-commerce (default)',
        'description' => 'Laravel e-commerce solution',
        'default' => true
    ];
});
