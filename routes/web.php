<?php

use Illuminate\Support\Facades\Route;
// hungtmph10583 (21/09/21) start
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// hungtmph10583 (21/09/21) end
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CustomerController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'home'])->name('client.home');
Route::get('/trang-chu', [HomeController::class, 'home'])->name('client.homes');

Route::prefix('san-pham')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('client.product.index');

    Route::get('/chi-tiet/{id}', [ProductController::class, 'detail'])->name('client.product.detail');
    Route::post('/chi-tiet/{id}', [ProductController::class, 'saveReview']);
});

Route::prefix('gio-hang')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('client.cart.index');

    Route::get('/chi-tiet/{id}', [CartController::class, 'detail'])->name('client.cart.detail');
    Route::post('/chi-tiet/{id}', [CartController::class, 'saveReview']);
});

// hungtmph10583 (21/09/21) start

Route::prefix('tai-khoan')->middleware('auth')->group(function () {
    Route::get('/', [CustomerController::class, 'accountInfo'])->name('client.customer.info');
    Route::get('cap-nhat', [CustomerController::class, 'updateinfo'])->name('client.customer.updateinfo');
    Route::post('cap-nhat', [CustomerController::class, 'saveUpdateinfo']);
    Route::get('doi-mat-khau/{id}', [CustomerController::class, 'changePForm'])->name('client.customer.changeP');
    Route::post('doi-mat-khau/{id}', [CustomerController::class, 'saveChangeP']);
});


// ------------------------------- Login -------------------------------
Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);

// ------------------------------- Register -------------------------------
Route::get('registration', [AuthController::class, 'registrationForm'])->name('registration');
Route::post('registration', [AuthController::class, 'saveRegistration']);

//------------------------------- Logout -------------------------------
Route::any('logout', function () {
    Auth::logout();
    return redirect(route('login'));
})->name('logout');

// ------------------------------- Forget password -------------------------------
Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('forgot-password', [AuthController::class, 'saveForgotPassword']);

// ------------------------------- Change password -------------------------------
Route::get('change-password', [AuthController::class, 'changePassword'])->middleware('auth')->name('changePassword');
Route::post('change-password', [AuthController::class, 'saveChangePassword']);

// Route::get('reset-password/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@getPassword');
// Route::post('reset-password', 'App\Http\Controllers\Auth\ResetPasswordController@updatePassword');

// hungtmph10583 (21/09/21) end