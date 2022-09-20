<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorizationRequest;
use App\Models\Authorization;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function index()
    {
        return view('authorization.index', [
            'authorizations' => Authorization::where('role_id', 1)->get(),
        ]);
    }

    public function save(Request $request)
    {
        // for ($i = 1; $i <= count($request->menus); $i++) {
        //     foreach ($request->types as $type) {
        //     }
        // }
        return response()->json($request->types);
    }
}
