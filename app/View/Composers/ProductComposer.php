<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

use App\Models\Menu;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductComposer
{
    protected $menus;
    protected $heading;
    protected $colSizes;
    protected $titles;
    protected $formInputs;
    protected $productCategories;

    public function __construct()
    {
        $this->menus = Menu::all();
        $this->heading = "Product";
        $this->colSizes = [1, 2, 2, 3, 3, 1, 2];
        $this->titles = [];
        $this->formInputs = [
            [
                [
                    "name" => 'product_categories_id',
                    'label' => 'Category',
                    'type' => 'select',
                ],
                [
                    "name" => 'name',
                    'label' => 'Name',
                    'type' => 'text',
                ],
                [
                    "name" => 'code',
                    'label' => 'Code',
                    'type' => 'text',
                ],
                [
                    "name" => 'status',
                    'label' => 'Status',
                    'type' => 'check',
                ],
                [
                    "name" => 'new_product',
                    'label' => 'New Product',
                    'type' => 'check',
                ],
                [
                    "name" => 'best_seller',
                    'label' => 'Best Seller',
                    'type' => 'check',
                ],
                [
                    "name" => 'featured',
                    'label' => 'Featured',
                    'type' => 'check',
                ],

            ],
            [
                [
                    "name" => 'price',
                    'label' => 'Price',
                    'type' => 'number',
                ],
                [
                    "name" => 'purchase_price',
                    'label' => 'Purchase Price',
                    'type' => 'number',
                ],
                [
                    "name" => 'short_description',
                    'label' => 'Short Description',
                    'type' => 'textarea',
                ],
                [
                    "name" => 'description',
                    'label' => 'Description',
                    'type' => 'textarea',
                ],
            ],
        ];
        $this->productCategories = ProductCategory::all();

        foreach (Schema::getColumnListing('products') as $i => $title) {
            if (!in_array($title, [
                'id',
                'description',
                'short_description',
                'new_product',
                'best_seller',
                'featured',
                'created_at',
                'updated_at',
            ])) {
                $titleArray = explode("_", $title);

                foreach ($titleArray as $i => $title) {
                    $titleArray[$i] = ucfirst($title);
                }

                $title = join(" ", $titleArray);

                array_push($this->titles, $title);
            }
        }
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
                'productCategories' => $this->productCategories,
            ]);
        }
    }
}
