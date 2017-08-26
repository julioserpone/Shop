<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\User\Http;

use Antvel\Http\Controller;
use Illuminate\Http\Request;
use Antvel\User\Repositories\PusNotificationsRepository;

class PushNotificationsController extends Controller
{
	/**
	 * Shows the user notifications list.
	 *
	 * @param  PusNotificationsRepository $notifications
	 *
	 * @return void
	 */
	public function index(PusNotificationsRepository $notifications)
	{
		return [
			'unread' => $notifications->unread(),
			'read' => $notifications->read(),
		];
	}
}
