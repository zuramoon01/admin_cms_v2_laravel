<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Menu;
use App\Models\AuthorizationType;
use App\Models\Authorization;

use App\Http\Requests\AuthorizationRequest;

class AuthorizationController extends Controller
{
    public function index()
    {
        return view('authorization.index', [
            'authorizations' => Authorization::where('role_id', 1)->get(),
        ]);
    }

    public function save(AuthorizationRequest $request)
    {
        $data = json_decode($request->data, true);
        $role = Role::where('id', $data['role'])->first();

        for ($i = 0; $i < count($data['menus']); $i++) {
            $menu = Menu::where('name', $data['menus'][$i])->first();

            for ($j = 0; $j < count($data['types'][$i]); $j++) {
                if ($data['types'][$i][$j] === 0) {
                    $authorization = Authorization::where('role_id', $role->id)
                        ->where('menu_id', $menu->id)
                        ->where('authorization_type_id', ($j + 1))
                        ->update(
                            [
                                'has_access' => false,
                            ]
                        );
                } else {
                    $authorizationType = AuthorizationType::where("id", $data['types'][$i][$j])->first();

                    $authorization = Authorization::where('role_id', $role->id)
                        ->where('menu_id', $menu->id)
                        ->where('authorization_type_id', $authorizationType->id)
                        ->update(
                            [
                                'has_access' => true,
                            ]
                        );
                }
            }
        }

        return response()->json('success');
    }
}
