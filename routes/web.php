<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
 */

use App\Http\Controllers\System\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\System\Auth\ForgotPasswordController as AuthForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
 */

use App\Http\Controllers\System\Admin\User\UsersController as AdminUsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/404', 'errors.404')->name('404');

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Unauthenticated
|--------------------------------------------------------------------------
 */

Route::middleware('unauthenticated')->group(function () {

    /*
   |--------------------------------------------------------------------------
   | Auth
   |--------------------------------------------------------------------------
    */

    Route::controller(AuthLoginController::class)->group(function () {

        Route::get('/login', 'getLogin')->name('login');

        Route::post('/login', 'postLogin')->name('login.post');

    });

    Route::get('/forgot-password', [AuthForgotPasswordController::class, 'getForgotPassword'])->name('forgot.password');

});

/*
|--------------------------------------------------------------------------
| Authenticate
|--------------------------------------------------------------------------
 */

Route::middleware('authenticate')->group(function () {

    Route::get('/logout', [AuthLoginController::class, 'getLogout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->middleware('admin')->as('admin.')->group(function () {

        Route::controller(AdminUsersController::class)->group(function () {

            Route::get('/users', 'getUsers')->name('users');

            Route::get('/user/{user_id?}', 'getUser')->name('user');

            Route::post('/user/{user_id?}', 'postUser')->name('user.post');

            Route::delete('/user/{user_id?}', 'deleteUser')->name('user.delete');
        });

    });

});