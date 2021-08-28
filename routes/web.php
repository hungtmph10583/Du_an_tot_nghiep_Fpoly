<?php

use Illuminate\Support\Facades\Route;
// hungtmph10583 (16/08/21) start
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// hungtmph10583 (16/08/21) end

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
// hungtmph10583 (16/08/21) start
Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::post('login', [AuthController::class, 'postLogin']);
Route::get('registration', [AuthController::class, 'registrationForm'])->name('registration');
Route::post('registration', [AuthController::class, 'postRegistration']);
Route::any('logout', function(){
    Auth::logout();
    return redirect(route('login'));
})->name('logout');
// hungtmph10583 (16/08/21) end