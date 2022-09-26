<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Support\Facades\Schema;

class TransactionComposer
{

    protected $menus;
    protected $heading;
    protected $colSizes;
    protected $titles;
    protected $transaction;
    protected $formInputs;

    public function __construct()
    {
        $this->menus = Menu::all();
        $this->heading = "Transaction";
        $this->colSizes = [1, 2, 1, 2, 3, 1, 1, 1];
        $this->titles = [];
        $this->transactions = Transaction::all();

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
        }
    }
}
