<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Categories\Requests;

use Epikfy\Http\Request;
use Illuminate\Validation\Rule;

class CategoriesRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|max:100',

            '_pictures_file' => [
                'mimes:jpeg,png,jpg',
                Rule::dimensions()->maxWidth(1000)->maxHeight(500)
            ],

            'name' => [
                'required',
                Rule::unique('categories')->ignore($this->request->get('current_category')),
            ],
        ];
    }
}
