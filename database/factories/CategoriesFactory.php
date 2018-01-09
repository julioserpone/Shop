<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Faker\Generator as Faker;
use Epikfy\Company\Models\Company;
use Epikfy\Categories\Models\Category;

$factory->define(Category::class, function (Faker $faker) use ($factory)
{
    return [
        'name' => str_limit($faker->sentence, 50),
        'description' => str_limit($faker->paragraph, 90),
        'icon' => $faker->randomElement(['glyphicon glyphicon-facetime-video', 'glyphicon glyphicon-bullhorn', 'glyphicon glyphicon-briefcase']),
    ];
});

$factory->defineAs(Category::class, 'child', function (Faker $faker)  use ($factory)
{
	return [
		'category_id' => function () {
            return factory(Category::class)->create(['name' => 'parent'])->id;
        },
    	'name' => 'child',
        'description' => str_limit($faker->paragraph, 90),
        'icon' => $faker->randomElement(['glyphicon glyphicon-facetime-video', 'glyphicon glyphicon-bullhorn', 'glyphicon glyphicon-briefcase']),
    ];
});
