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

use Epikfy\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Allowed managers.
     *
     * @var array
     */
    protected $managers = [];

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->managers = Roles::managers();
    }

    /**
     * Checks whether a given user can manage the store.
     *
     * @param  User $user
     *
     * @return bool
     */
    public function manageStore(User $user)
    {
        return in_array($user->role, $this->managers);
    }
}
