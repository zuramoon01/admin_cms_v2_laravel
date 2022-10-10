<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

use App\Models\Menu;
use App\Models\ProductCategory;

class ProductCategoryComposer
{
    protected $heading;
    protected $colSizes;
    protected $titles;
    protected $formInputs;

    public function __construct()
    {
        $this->menus = Menu::all();
        $this->heading = "Product Category";
        $this->colSizes = [1, 3, 7, 1];
        $this->titles = Schema::getColumnListing('product_categories');
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

        if ($viewType === 'index') {
            $view->with([
                'menus' => $this->menus,
                'heading' => $this->heading,
                'colSizes' => $this->colSizes,
                'titles' => $this->titles,
            ]);
        } elseif ($viewType === 'form') {
            $view->with([
                'menus' => $this->menus,
                'heading' => $this->heading,
                'formInputs' => $this->formInputs,
            ]);
        }
    }
}
