<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Users\Policies;

trait PolicyMap
{
	/**
     * The policy mappings for Epikfy.
     *
     * @var array
     */
    protected $policies = [
        \Epikfy\Users\Models\User::class => UserPolicy::class,
    ];
}
