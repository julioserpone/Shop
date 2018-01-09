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

trait EventMap
{
	/**
     * All of the Epikfy User event / listener mappings.
     *
     * @var array
     */
    protected $events = [
        \Illuminate\Notifications\Events\NotificationSent::class => [
            \Epikfy\Users\Listeners\UpdateNotificationType::class
        ],

		\Epikfy\Users\Events\ProfileWasUpdated::class => [
            \Epikfy\Users\Listeners\UpdateProfile::class,
            \Epikfy\Users\Listeners\SendNewEmailConfirmation::class,
        ],

        \Epikfy\Features\Events\FeatureNameWasUpdated::class => [
            \Epikfy\Features\Listeners\UpdateFeatureName::class,
        ],
    ];
}
