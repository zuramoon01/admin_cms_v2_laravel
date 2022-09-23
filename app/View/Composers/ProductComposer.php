<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

use App\Models\Product;

class ProductComposer
{

    protected $heading;
    protected $colSizes;
    protected $titles;
    protected $product;
    protected $formInputs;

    public function __construct()
    {
        $this->heading = "Product";
        $this->colSizes = [1, 2, 2, 3, 3, 1, 2];
        $this->titles = [];
        $this->products = Product::all();
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
                'heading' => $this->heading,
                'colSizes' => $this->colSizes,
                'titles' => $this->titles,
                'products' => $this->products,
            ]);
        } elseif ($viewType === 'form') {
            $view->with([
                'heading' => $this->heading,
                'formInputs' => $this->formInputs,
            ]);
        }
    }
}
