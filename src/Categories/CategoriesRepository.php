<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel\Categories;

class CategoriesRepository
{
    /**
     * Returns the categories with products filtered by the given request.
     *
     * @param array $request
     * @param integer $limit
     * @param mixed $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categoriesWithProducts(array $request = [], $limit = 10, $columns = '*')
    {
        $categories = Models\Category::whereHas('products', function($query) {
            return $query->actives();
        });

        return $categories->select($columns)->filter($request)
            ->orderBy('name')
            ->take($limit)
            ->get();
    }

    /**
     * Returns the children for the given category.
     *
     * @param  Category|mixed $idOrModel $idOrModel
     * @param int $limit
     * @param array $columns
     *
     * @return \Illuminate/Database/Eloquent/Collection
     */
    public function childrenOf($category_id, int $limit = 50, $columns = 'id')
    {
        return Models\Category::select($columns)->with('children')
            ->where('category_id', $category_id)
            ->orderBy('updated_at', 'desc')
            ->take($limit)
            ->get();
    }
}
