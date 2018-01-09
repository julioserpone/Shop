<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Users\Http;

use Epikfy\Http\Controller;
use Illuminate\Http\Request;
use Epikfy\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Epikfy\Users\Events\ProfileWasUpdated;

class ProfileController extends Controller
{
    /**
     * Shows the user profile.
     *
     * @return void
     */
	public function index()
	{
        return $this->show();
	}

    /**
     * Shows the user profile.
     *
     * @return void
     */
    public function show()
    {
        return view('users.show');
    }

    /**
     * Updates the user profile.
     *
     * @param  ProfileRequest $request
     * @param  User $user
     *
     * @return void
     */
    public function update(ProfileRequest $request, User $user)
    {
        event(new ProfileWasUpdated($request));

        if ($request->wantsJson()) {
            return $this->respondsWithSuccess('ok');
        }

        return back();
    }

}
