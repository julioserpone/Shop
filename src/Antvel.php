<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antvel;

use Antvel\Http\Routes\AntvelRouter;
use Illuminate\Support\Facades\Route;

class Antvel
{
    /**
     * The Antvel Shop version.
     *
     * @var string
     */
    const VERSION = '1.2.6';

    /**
     * All of the service bindings for Antvel.
     *
     * @return array
     */
    public static function bindings()
    {
        return [
            Contracts\CategoryRepositoryContract::class => Categories\Repositories\CategoriesRepository::class,
            Contracts\FeaturesRepositoryContract::class => Features\Repositories\FeaturesRepository::class,
        ];
    }

    /**
     * All of the service aliases for Antvel.
     *
     * @return array
     */
    public static function alias()
    {
        return [
            'category.repository' => Categories\Repositories\CategoriesRepository::class,
            'category.repository.cahe' => Categories\Repositories\CategoriesCacheRepository::class,
            'product.features.repository' => Features\Repositories\FeaturesRepository::class,
            'product.features.repository.cahe' => Features\Repositories\FeaturesCacheRepository::class,
        ];
    }

    /**
     * Registers Antvel events and listeners.
     *
     * @return void
     */
    public static function events()
    {
        (new \Antvel\Support\EventsRegistrar)->registrar();
    }

    /**
     * Register the antvel policies.
     *
     * @return void
     */
    public static function policies()
    {
        (new \Antvel\Support\PoliciesRegistrar)->registrar();
    }

    /**
     * Get a Antvel route registrar.
     *
     * @param  callable|null $callback
     * @param  array $options
     *
     * @return void
     */
    public static function routes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            AntvelRouter::make($router);
        };

        $defaultOptions = [
            'namespace' => 'Antvel',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback($router);
        });
    }
}
