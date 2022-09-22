<?php

namespace App\View\Composers;

use App\Models\AuthorizationType;
use App\Models\Menu;
use Illuminate\View\View;

use App\Models\Role;

class AuthorizationComposer
{
    protected $heading;
    protected $roles;
    protected $colSizes;
    protected $authorizationTypes;
    protected $menus;

    public function __construct()
    {
        $this->heading = "Authorization";
        $this->roles = Role::all();
        $this->colSizes = [4, 2, 2, 2, 2];
        $this->authorizationTypes = AuthorizationType::all();
        $this->menus = Menu::all();
    }

    public function compose(View $view)
    {
        $view->with([
            'heading' => $this->heading,
            'roles' => $this->roles,
            'colSizes' => $this->colSizes,
            'authorizationTypes' => $this->authorizationTypes,
            'menus' => $this->menus,
        ]);
    }
}
