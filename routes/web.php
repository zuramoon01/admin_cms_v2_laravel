<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorizationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::view('/', 'index')->middleware('auth')->name('dashboard');

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')
        ->prefix('/login')->group(function () {
            Route::get('/', 'loginPage')->name('login');
            Route::post('/', 'loginUser');
        });

    Route::get('/logout', 'logoutUser')->middleware('auth');
});

Route::middleware(['auth', 'route.authorization'])->group(function () {
    Route::controller(AuthorizationController::class)
        ->prefix('/authorizations')
        ->name('authorization.')->group(function () {
            Route::get('/', 'index')->name('index.view');
            Route::post('/save', 'save')->name('save.edit');
        });
});
