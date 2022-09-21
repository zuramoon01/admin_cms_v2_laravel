<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

use App\Models\ProductCategory;

class ProductCategoryComposer
{
    protected $colSizes;
    protected $titles;
    protected $productCategories;

    public function __construct()
    {
        $this->colSizes = [1, 3, 7, 1];
        $this->titles = Schema::getColumnListing('product_categories');
        $this->productCategories = ProductCategory::all();

        array_shift($this->titles);
    }

    public function compose(View $view)
    {
        $view->with([
            'colSizes' => $this->colSizes,
            'titles' => $this->titles,
            'productCategories' => $this->productCategories,
        ]);
    }
}
