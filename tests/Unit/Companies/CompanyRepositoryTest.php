<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Tests\Unit\Companies;

use Epikfy\Tests\TestCase;
use Epikfy\Companies\Models\Company;
use Epikfy\Companies\CompanyRepository;

class CompanyRepositoryTest extends TestCase
{
	/** @test */
	function it_returns_the_default_company()
	{
		$companyA = factory(Company::class)->create();
		$companyB = factory(Company::class)->states('default')->create([
			'name' => 'foo',
			'description' => 'bar'
		]);

		tap((new CompanyRepository)->default(), function ($default) {
			$this->assertEquals('foo', $default->name);
			$this->assertEquals('bar', $default->description);
		});
	}

	/** @test */
	function it_returns_a_factory_company_if_the_default_one_was_not_found()
	{
		$company = factory(Company::class)->create();

		tap((new CompanyRepository)->default(), function ($default) {
			$this->assertEquals('Epikfy e-commerce', $default['name']);
			$this->assertEquals('Laravel e-commerce solution.', $default['description']);
		});
	}
}
