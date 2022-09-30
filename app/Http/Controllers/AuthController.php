<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('login.index');
    }

    public function loginUser(AuthRequest $request)
    {
        $credentials = $request->validated();

        // $admin = Admin::where('username', $credentials['username'])->first();

        // if (!$admin || !Hash::check($request->password, $admin->password)) {
        //     throw ValidationException::withMessages([
        //         'username' => ['The provided credentials are incorrect.'],
        //     ]);
        // }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->user()->createToken('user_token')->plainTextToken;

            return to_route('dashboard');
        }
    }

    public function logoutUser(Request $request)
    {
        $user = Admin::where('username', auth()->user()->username)->first();
        $user->tokens()->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }
}
