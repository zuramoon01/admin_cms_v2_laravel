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
    protected $customerColSizes;
    protected $transactionDetailColSizes;
    protected $voucherUsageColSizes;
    protected $titles;
    protected $customerTitles;
    protected $transactionDetailTitles;
    protected $voucherUsageTitles;
    protected $formInputs;
    protected $products;
    protected $vouchers;
    protected $detail;

    public function __construct()
    {
        $this->menus = Menu::all();
        $this->heading = "Transaction";
        $this->colSizes = [1, 2, 1, 2, 3, 1, 1, 1];
        $this->customerColSizes = [3, 3, 2, 3, 1];
        $this->transactionDetailColSizes = [3, 3, 3, 3];
        $this->voucherUsageColSizes = [6, 6];
        $this->titles = [];
        $this->customerTitles = [
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Additional Request',
            'Payment Method'
        ];
        $this->transactionDetailTitles = [
            'Product',
            'Quantity',
            'Price',
            'Total'
        ];
        $this->voucherUsageTitles = [
            'Code',
            'Discounted Value',
        ];
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

        $this->details =
            [
                [
                    'heading' => true,
                    'tableHeading' => 'Customer',
                    'colSizes' => $this->customerColSizes,
                    'tableTitle' => $this->customerTitles,
                ],
                [
                    'heading' => false,
                    'tableHeading' => 'Transaction Detail',
                    'colSizes' => $this->transactionDetailColSizes,
                    'tableTitle' => $this->transactionDetailTitles,
                ],
                [
                    'heading' => false,
                    'tableHeading' => 'Voucher Usage',
                    'colSizes' => $this->voucherUsageColSizes,
                    'tableTitle' => $this->voucherUsageTitles,
                ],
            ];
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
                'products' => $this->products,
                'vouchers' => $this->vouchers,
            ]);
        } elseif ($viewType === 'detail') {
            $view->with([
                'menus' => $this->menus,
                'heading' => "$this->heading Detail",
                'details' => $this->details,
            ]);
        }
    }
}
