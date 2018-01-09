<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Concerns;

trait InteractWithUsers
{
    /**
     * Sign in a given user.
     *
     * @param  string $state
     * @param  array  $attr
     *
     * @return void
     */
    protected function signIn($attr = [])
    {
        $user = factory('Epikfy\Users\Models\User')->create($attr);

        $this->actingAs($user);

        return $user;
    }

    /**
     * Sign in an user as given state.
     *
     * @param  string $state
     * @param  array  $attr
     *
     * @return void
     */
    protected function signInAs($state, $attr = [])
    {
        $user = factory('Epikfy\Users\Models\User')->states($state)->create($attr);

        $this->actingAs($user);

        return $user;
    }
}
