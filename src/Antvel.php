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

use Illuminate\Container\Container;
use Antvel\Http\Routes\AntvelRouter;
use Illuminate\Support\Facades\Route;

class Antvel
{
    /**
     * The Antvel Shop version.
     *
     * @var string
     */
    const VERSION = '1.2.2';

    /**
     * The Laravel container component.
     *
     * @var Container
     */
    protected $container = null;

    /**
     * Creates a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->container = Container::getInstance();
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
