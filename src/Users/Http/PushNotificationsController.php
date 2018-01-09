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
use Epikfy\Users\Repositories\PushNotificationsRepository;

class PushNotificationsController extends Controller
{
	/**
	 * Shows the signed user notifications list.
	 *
	 * @param  PusNotificationsRepository $notifications
	 *
	 * @return void
	 */
	public function index(PushNotificationsRepository $notifications)
	{
		return [
			'unread' => $notifications->unread(),
			'read' => $notifications->read(),
		];
	}
}
