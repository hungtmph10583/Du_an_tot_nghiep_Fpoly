<?php

use Illuminate\Support\Facades\Route;
// hungtmph10583 (21/09/21) start
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// hungtmph10583 (21/09/21) end
use App\Http\Controllers\Client\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('san-pham')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.client.index');
    Route::get('/chi-tiet/{id}', [ProductController::class, 'detail'])->name('product.client.detail');
});

// hungtmph10583 (21/09/21) start

// ------------------------------- Login -------------------------------
Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);

// ------------------------------- Register -------------------------------
// Route::get('registration', [AuthController::class, 'registrationForm'])->name('registration');
// Route::post('registration', [AuthController::class, 'postRegistration']);

//------------------------------- Logout -------------------------------
Route::any('logout', function(){
    Auth::logout();
    return redirect(route('login'));
})->name('logout');

// ------------------------------- Forget password -------------------------------
// Route::get('forget-password', 'App\Http\Controllers\Auth\ForgotPasswordController@getEmail')->name('forget-password');
// Route::post('forget-password', 'App\Http\Controllers\Auth\ForgotPasswordController@postEmail')->name('forget-password');

// Route::get('reset-password/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@getPassword');
// Route::post('reset-password', 'App\Http\Controllers\Auth\ResetPasswordController@updatePassword');

// hungtmph10583 (21/09/21) end