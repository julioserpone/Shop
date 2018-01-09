<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Support\Images;

use Epikfy\Http\Controller;
use Illuminate\Http\Request;

class RenderController extends Controller
{
	/**
	 * Renders the given imagen.
	 *
	 * @param  Request $request
	 * @param  string $file
	 *
	 * @return void
	 */
	public function index(Request $request, $file)
	{
		$options = $request->all();

		return Render::image($file, $options)->cast();
	}
}
