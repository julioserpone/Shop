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
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Loads the company about information.
     *
     * @param  CompanyRepository $repository
     * @param  string $section
     *
     * @return void
     */
    public function index(CompanyRepository $repository, $section = null)
    {
        if (is_null($section)) {
            $section = 'about';
        }

        $company = $repository->default();

        abort_if(is_null($company->$section), 404);

        return view('about.index', [
            'tab' => $section
        ]);
    }
}
