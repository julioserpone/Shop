<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Contracts;

interface CategoryRepositoryContract
{
    /**
     * Returns the categories with products filtered by the given request.
     *
     * @param array $request
     * @param int $limit
     * @param mixed $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categoriesWithProducts(array $request = [], $limit = 10, $columns = '*');

    /**
     * Returns the children for the given category.
     *
     * @param int $category_id
     * @param int $limit
     * @param mixed $columns
     *
     * @return \Illuminate/Database/Eloquent/Collection
     */
    public function childrenOf($category_id, int $limit = 50, $columns = 'id');
}
