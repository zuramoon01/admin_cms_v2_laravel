<?php

namespace App\View\Composers;

use App\Models\Menu;
use App\Models\Voucher;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

class VoucherComposer
{
    protected $menus;
    protected $heading;
    protected $colSizes;
    protected $titles;
    protected $vouchers;

    public function __construct()
    {
        $this->menus = Menu::all();
        $this->heading = "Voucher";
        $this->colSizes = [1, 2, 2, 2, 2, 2, 1];
        $this->titles = [];
        $this->vouchers = Voucher::all();

        foreach (Schema::getColumnListing('vouchers') as $i => $title) {
            if (!in_array($title, [
                'id',
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
                'vouchers' => $this->vouchers,
            ]);
        }
    }
}
