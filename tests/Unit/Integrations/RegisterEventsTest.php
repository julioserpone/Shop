<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Unit\Integrations;

use Epikfy\Tests\TestCase;

class RegisterEventsTest extends TestCase
{
	public function setUp()
    {
    	parent::setUp();

    	$this->events = [
    		\Epikfy\Features\Events\FeatureNameWasUpdated::class,
    		\Epikfy\Users\Events\ProfileWasUpdated::class,
    	];
    }

	/** @test */
	function it_is_able_to_register_the_Epikfy_events_within_the_application()
	{
		$this->app->booted(function () {
	    	foreach ($this->events as $event) {
	    		$this->assertTrue(count($this->app->make('events')->getListeners($event)) > 0);
	    	}
    	});
	}
}
