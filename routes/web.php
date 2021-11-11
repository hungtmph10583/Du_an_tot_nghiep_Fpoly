<?php

use Illuminate\Support\Facades\Route;
// hungtmph10583 (21/09/21) start
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
// use App\Http\Controllers\Auth\ResetPasswordController;
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
    
    Route::get('/show-cart', [CartController::class, 'showCart'])->name('showCart');
    Route::post('/save-cart', [CartController::class, 'saveCart'])->name('saveCart');

    Route::get('/delete-to-cart/{rowId}', [CartController::class, 'deleteToCart'])->name('deleteToCart');
    Route::post('/update-cart-quantity/{rowId}', [CartController::class, 'updateCartQty'])->name('updateCartQty');

    Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('checkout', [CartController::class, 'saveCheckout']);

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
// Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
// Route::post('forgot-password', [AuthController::class, 'saveForgotPassword']);

// ------------------------------- Change password -------------------------------
Route::get('change-password', [AuthController::class, 'changePassword'])->middleware('auth')->name('changePassword');
Route::post('change-password', [AuthController::class, 'saveChangePassword']);

// ------------------------------- Reset password -------------------------------
// Route::post('reset-password', 'ResetPasswordController@sendMail');
Route::get('forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('reset-password', [ResetPasswordController::class, 'sendMail'])->name('resetPassword');
Route::put('reset-password/{token}', [ResetPasswordController::class, 'reset']);
// Route::put('reset-password/{token}', 'ResetPasswordController@reset');

// hungtmph10583 (21/09/21) end