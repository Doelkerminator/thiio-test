<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\VerifyJwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/user', function() {
    dd(Auth::user());
});

Route::controller(UserController::class) -> group(function () {
    
    Route::post('/login', 'login');
    Route::post('/signup', 'signup');

    Route::middleware(VerifyJwt::class) -> group(function () {
        Route::delete('/logout', 'logout');
        Route::patch('/update', 'update');
        Route::delete('/delete', 'delete');
        Route::get('/session', 'session');

        Route::middleware(AdminCheck::class) -> group(function () {
            Route::get('/admin/users', 'users');
            Route::delete('/admin/drop/{id}', 'drop');
        });
    });
});
