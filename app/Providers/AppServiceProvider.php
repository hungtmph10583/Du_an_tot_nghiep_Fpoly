<?php

namespace App\Providers;

use App\Models\CategoryType;
use Illuminate\Support\ServiceProvider;

/**
 * hungtm
 * @date: 28/09/21
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * hungtm
         * @date: 28/09/21
         */
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        View::composer(['layouts.admin.aside'], function ($view) {
            $categoryType = CategoryType::get();
            $view->with('cateType', $categoryType);
        });
    }
}