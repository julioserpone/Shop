<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Unit\Notifications;

use Epikfy\Epikfy;
use Epikfy\Tests\TestCase;
use Epikfy\Notifications\Parsers\Templates;

class TemplatesTest extends TestCase
{
	/** @test */
	function it_returns_empty_if_labels_were_not_found()
	{
		$this->assertCount(0, Templates::make('foo')->all());
	}

	/** @test */
	function it_returns_empty_if_label_was_not_found()
	{
		$this->assertNull(Templates::make('foo')->get('bar'));
	}

	/** @test */
	function it_returns_a_valid_given_key_labels()
	{
		$labels = Templates::make('push.orders')->all();

		$this->assertTrue(is_array($labels));
		$this->assertTrue(count($labels) > 0);
	}

	/** @test */
	function it_returns_a_valid_given_key_labels_from_defaults()
	{
		$labels = (new Templates('push.orders'))->default();

		$this->assertTrue(is_array($labels));
		$this->assertTrue(count($labels) > 0);
	}
}
