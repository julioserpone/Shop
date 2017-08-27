<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\User\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PusNotificationsRepository
{
    /**
     * Shows the unread user notifications formatted.
     *
     * @return array
     */
    public function unread()
    {
        return Auth::user()->unreadNotifications->map(function ($item) {
            return $this->toCollect($item);
        });
    }

    /**
     * Shows the read user notifications formatted.
     *
     * @return array
     */
    public function read()
    {
        return Auth::user()->notifications()->whereNotNull('read_at')->get()->map(function ($item) {
            return $this->toCollect($item);
        });
    }

    /**
     * Shows the read user notifications formatted.
     *
     * @return array
     */
    public function all()
    {
        return Auth::user()->notifications->map(function ($item) {
            return $this->toCollect($item);
        });
    }

    /**
     * Formats the given notification to the desired array.
     *
     * @param  mixed $notification
     *
     * @return array
     */
    protected function toCollect($notification) : Collection
    {
        return Collection::make([
            'hasBeenRead' => ! is_null($notification->read_at),
            'path' => $notification->data['source_path'],
            'label' => $notification->data['label'],
            'id' => $notification->id,
        ]);
    }
}
