<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\View\Composers\DashboardComposer;
use App\View\Composers\AuthorizationComposer;
use App\View\Composers\ProductCategoryComposer;

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
        View::composer('layouts.dashboard', DashboardComposer::class);
        View::composer('authorization.index', AuthorizationComposer::class);
        View::composer('product-category.index', ProductCategoryComposer::class);
    }
}
