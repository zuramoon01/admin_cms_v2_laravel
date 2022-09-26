<?php

namespace App\View\Composers;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\Transaction;
use App\Models\Voucher;
use Illuminate\Support\Facades\Schema;

class TransactionComposer
{

    protected $menus;
    protected $heading;
    protected $colSizes;
    protected $titles;
    protected $transaction;
    protected $formInputs;
    protected $products;
    protected $vouchers;

    public function __construct()
    {
        $this->menus = Menu::all();
        $this->heading = "Transaction";
        $this->colSizes = [1, 2, 1, 2, 3, 1, 1, 1];
        $this->titles = [];
        $this->transactions = Transaction::all();
        $this->formInputs = [
            [
                "name" => 'customer_name',
                'label' => 'Customer Name',
                'type' => 'text',
            ],
            [
                "name" => 'customer_email',
                'label' => 'Customer Email',
                'type' => 'text',
            ],
            [
                "name" => 'customer_phone',
                'label' => 'Customer Phone',
                'type' => 'text',
            ],
            [
                "name" => 'additional_request',
                'label' => 'Additional Request',
                'type' => 'textarea',
            ],
            [
                "name" => 'payment_method',
                'label' => 'Payment Method',
                'type' => 'select',
                'data' => [
                    [
                        'label' => 'Cash',
                        'value' => 'Cash',
                    ],
                    [
                        'label' => 'Debit',
                        'value' => 'Debit',
                    ],
                ],
            ],
            [
                "name" => 'status',
                'label' => 'Status',
                'type' => 'select',
                'data' => [
                    [
                        'label' => 'Cancelled',
                        'value' => 0,
                    ],
                    [
                        'label' => 'Pending',
                        'value' => 1,
                    ],
                    [
                        'label' => 'Done / Paid',
                        'value' => 2,
                    ],
                ],
            ],
        ];
        $this->products = Product::all();
        $this->vouchers = Voucher::all();

        foreach (Schema::getColumnListing('transactions') as $title) {
            if (!in_array($title, [
                'id',
                'customer_email',
                'customer_phone',
                'sub_total',
                'total',
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
                'transactions' => $this->transactions,
            ]);
        } elseif ($viewType === 'form') {
            $view->with([
                'menus' => $this->menus,
                'heading' => $this->heading,
                'formInputs' => $this->formInputs,
                'products' => $this->products,
                'vouchers' => $this->vouchers,
            ]);
        }
    }
}
