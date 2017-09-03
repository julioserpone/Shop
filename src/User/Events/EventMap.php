<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\User\Events;

trait EventMap
{
	/**
     * All of the Antvel User event / listener mappings.
     *
     * @var array
     */
    protected $events = [
		\Antvel\User\Events\ProfileWasUpdated::class => [
            \Antvel\User\Listeners\UpdateProfile::class,
            \Antvel\User\Listeners\SendNewEmailConfirmation::class,
        ],

        \Antvel\Features\Events\FeatureNameWasUpdated::class => [
            \Antvel\Features\Listeners\UpdateFeatureName::class,
        ],
    ];
}
