<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\View\Composers\DashboardComposer;
use App\View\Composers\AuthorizationComposer;
use App\View\Composers\ProductCategoryComposer;
use App\View\Composers\ProductComposer;
use App\View\Composers\TransactionComposer;
use App\View\Composers\VoucherComposer;

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
        View::composer('authorization.index', AuthorizationComposer::class);
        View::composer(['product-category.index', 'product-category.form'], ProductCategoryComposer::class);
        View::composer(['product.index', 'product.form'], ProductComposer::class);
        View::composer(['voucher.index', 'voucher.form'], VoucherComposer::class);
        View::composer(['transaction.index', 'transaction.form'], TransactionComposer::class);
    }
}
