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
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Shows the contact us form.
     *
     * @return void
     */
    public function create()
    {
        return view('about.create');
    }

    /**
     * Sends the contact us email.
     *
     * @param  Request $request
     * @param  CompanyRepository $repository
     *
     * @return void
     */
    public function store(Request $request, CompanyRepository $repository)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $company = $repository->default();

        Mail::to($company->email)->send(new SendContactEmail($company, $data));

        return redirect()
            ->route('contact')
            ->with('message', trans('company.contact.message'));
    }
}
