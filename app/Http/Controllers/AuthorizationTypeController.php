<?php

namespace App\Http\Controllers;

use App\Models\AuthorizationType;
use Illuminate\Http\Request;

class AuthorizationTypeController extends Controller
{
    public function getAuthorizationTypes()
    {
        $authorizationTypes = AuthorizationType::all();

        return response()->json($authorizationTypes);
    }
}
