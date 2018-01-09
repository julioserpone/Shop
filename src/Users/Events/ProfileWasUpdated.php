<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Users\Events;

use Illuminate\Queue\SerializesModels;

class ProfileWasUpdated
{
    use SerializesModels;

    /**
     * The laravel request data.
     *
     * @var \Illuminate\Http\Request|Illuminate\Support\Collection
     */
    public $request = null;

    /**
     * The change email petition.
     *
     * @var \Epikfy\Users\Models\EmailChangePetition
     */
    public $petition = null;

    /**
     * Create a new event instance.
     *
     * @param \Illuminate\Http\Request|Illuminate\Support\Collection $request
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }
}
