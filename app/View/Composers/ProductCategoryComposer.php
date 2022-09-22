<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

use App\Models\ProductCategory;

class ProductCategoryComposer
{
    protected $heading;
    protected $colSizes;
    protected $titles;
    protected $productCategories;
    protected $formInputs;

    public function __construct()
    {
        $this->heading = "Product Category";
        $this->colSizes = [1, 3, 7, 1];
        $this->titles = Schema::getColumnListing('product_categories');
        $this->productCategories = ProductCategory::all();
        $this->formInputs = [
            [
                "name" => 'category',
                'label' => 'Category',
                'type' => 'text',
            ],
            [
                "name" => 'description',
                'label' => 'Description',
                'type' => 'textarea',
            ],
        ];

        array_shift($this->titles);
    }

    public function compose(View $view)
    {
        $viewName = explode(".", $view->name());
        $viewType = $viewName[count($viewName) - 1];

        $view->with([
            'heading' => $this->heading,
            'colSizes' => $this->colSizes,
            'titles' => $this->titles,
            'productCategories' => $this->productCategories,
        ]);
    }
}
