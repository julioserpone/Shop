<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Companies;

use Epikfy\Http\Controller;
use Epikfy\Companies\Models\Company;

class CompanyRepository
{
	/**
	 * Returns the default company.
	 *
	 * @return Company
	 */
	public function default() : Company
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
	public function fake() : Company
	{
		return Company::make([
	        'name' => 'Epikfy e-commerce',
	        'description' => 'Laravel e-commerce solution.',
	        'email' => 'gocanto@Epikfy.com',
	        'logo' => 'epikfy.jpg',
	        'slogan' => 'Epikfy e-commerce.',
	        'contact_email' => 'contact@epikfy.com',
	        'sales_email' => 'sales@epikfy.com',
	        'support_email' => 'support@epikfy.com',
	        'phone_number' => '+14056696453',
	        'cell_phone' => '+14056696453',
	        'address' => '4576 SE 44',
	        'state' => 'OK',
	        'city' => 'Norman',
	        'zip_code' => '79002',
	        'website' => 'http://epikfy.com',
	        'twitter' => 'https://twitter.com/_Epikfy',
	        'facebook' => 'https://www.facebook.com/Epikfyecommerce',
	        'keywords' => 'Epikfy',
	        'about' => 'Laravel e-commerce solution.',
	        'terms' => 'Epikfy e-commerce terms & conditions.',
	        'refunds' => 'Epikfy e-commerce refunds policies',
		]);
	}
}
