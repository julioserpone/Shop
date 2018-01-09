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

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('company', $this->company());
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Returns the default company to be shared with all the application views.
     *
     * @return \Epikfy\Companies\Models\Company
     */
    protected function company()
    {
        if ($this->app->runningInConsole()) {
            return (new CompanyRepository)->fake();
        }

        return (new CompanyRepository)->default();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['epikfy-company'];
    }
}
