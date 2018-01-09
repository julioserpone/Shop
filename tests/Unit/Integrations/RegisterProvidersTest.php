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

use Epikfy\Epikfy;
use Epikfy\Tests\TestCase;

class RegisterProvidersTest extends TestCase
{
	/** @test */
	function check_whether_the_Epikfy_providers_were_loaded()
	{
		foreach (Epikfy::providers() as $provider) {
			$this->assertArrayHasKey($provider, $this->app->getLoadedProviders());
		}
	}
}
