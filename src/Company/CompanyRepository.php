<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Company;

use Antvel\Http\Controller;
use Illuminate\Support\Collection;
use Antvel\Company\Models\Company;

class CompanyRepository
{
	/**
	 * Returns the default company.
	 *
	 * @return Company\Collection
	 */
	public function default()
	{
		$company = Company::where(['status' => true, 'default' => true])->first();

		if (is_null($company)) {
			return $this->fake();
		}

		return $company;
	}

	/**
	 * Returns a testing company.
	 *
	 * @return Company
	 */
	public function fake() : Collection
	{
		return Collection::make([
	        'name' => 'Antvel e-commerce',
	        'description' => 'Laravel e-commerce solution.',
	        'email' => 'gocanto@antvel.com',
	        'logo' => 'antvel.jpg',
	        'slogan' => 'Antvel e-commerce.',
	        'contact_email' => 'contact@antvel.com',
	        'sales_email' => 'sales@antvel.com',
	        'support_email' => 'support@antvel.com',
	        'phone_number' => '+14056696453',
	        'cell_phone' => '+14056696453',
	        'address' => '4576 SE 44',
	        'state' => 'OK',
	        'city' => 'Norman',
	        'zip_code' => '79002',
	        'website' => 'http://antvel.com',
	        'twitter' => 'https://twitter.com/_antvel',
	        'facebook' => 'https://www.facebook.com/antvelecommerce',
	        'keywords' => '',
	        'about' => 'about',
	        'terms' => 'terms',
	        'refunds' => 'refunds',
		]);
	}
}
