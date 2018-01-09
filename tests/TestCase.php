<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends Orchestra
{
    use Concerns\Environment,
        Concerns\InteractWithUsers,
        Concerns\InteractWithPictures;

    /**
     * The MySql testing db.
     *
     * This db is used just to test the queries related to products filters
     * because SqlLite does not support queries against JSON columns.
     */
    const TESTING_DB = 'epikfy_testing';

    /**
     * Setup the test environment
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->loadFactories();
        $this->loadMigrations();
    }
}
