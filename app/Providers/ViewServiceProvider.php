<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\View\Composers\DashboardComposer;
use App\View\Composers\AuthorizationComposer;
use App\View\Composers\ProductCategoryComposer;
use App\View\Composers\ProductComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('components.dashboard.partials._sidebar', DashboardComposer::class);
        View::composer('authorization.index', AuthorizationComposer::class);
        View::composer(['product-category.index', 'product-category.form'], ProductCategoryComposer::class);
        View::composer(['product.index', 'product.form'], ProductComposer::class);
    }
}
