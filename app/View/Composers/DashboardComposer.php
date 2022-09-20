<?php

namespace App\View\Composers;

use Illuminate\View\View;

use App\Models\Menu;

class DashboardComposer
{
    protected $menus;

    public function __construct()
    {
        $this->menus = Menu::all();
    }

    public function compose(View $view)
    {
        $view->with('menus', $this->menus);
    }
}
