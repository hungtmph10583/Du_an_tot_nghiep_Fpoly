<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BreedController;
use App\Http\Controllers\Admin\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

Route::prefix('tai-khoan')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('xoa/{id}', [UserController::class, 'remove'])->name('user.remove');
    Route::get('tao-moi', [UserController::class, 'addForm'])->name('user.add');
    Route::post('tao-moi', [UserController::class, 'saveAdd']);
    Route::get('cap-nhat/{id}', [UserController::class, 'editForm'])->name('user.edit');
    Route::post('cap-nhat/{id}', [UserController::class, 'saveEdit']);
    Route::get('ho-so/{id}', [UserController::class, 'proFile'])->name('user.profile');
    Route::get('doi-mat-khau/{id}', [UserController::class, 'changePForm'])->name('user.changeP');
    Route::post('doi-mat-khau/{id}', [UserController::class, 'saveChangeP']);
});

Route::prefix('danh-muc')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');

    Route::get('tao-moi', [CategoryController::class, 'addForm'])->name('category.add');
    Route::post('tao-moi', [CategoryController::class, 'saveAdd']);

    Route::get('cap-nhat/{id}', [CategoryController::class, 'editForm'])->name('category.edit');
    Route::post('cap-nhat/{id}', [CategoryController::class, 'saveEdit']);;

    Route::get('chi-tiet/{id}', [CategoryController::class, 'detail'])->name('category.detail');

    Route::get('xoa/{id}', [CategoryController::class, 'remove'])->name('category.remove');
});

Route::prefix('giong-loai')->group(function () {
    Route::get('/', [BreedController::class, 'index'])->name('breed.index');

    Route::get('tao-moi', [BreedController::class, 'addForm'])->name('breed.add');
    Route::post('tao-moi', [BreedController::class, 'saveAdd']);

    Route::get('cap-nhat/{id}', [BreedController::class, 'editForm'])->name('breed.edit');
    Route::post('cap-nhat/{id}', [BreedController::class, 'saveEdit']);;

    Route::get('chi-tiet/{id}', [BreedController::class, 'detail'])->name('breed.detail');

    Route::get('xoa/{id}', [BreedController::class, 'remove'])->name('breed.remove');
});

Route::prefix('san-pham')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');

    Route::get('tao-moi', [ProductController::class, 'addForm'])->name('product.add');
    Route::post('tao-moi', [ProductController::class, 'saveAdd']);

    Route::get('cap-nhat/{id}', [ProductController::class, 'editForm'])->name('product.edit');
    Route::post('cap-nhat/{id}', [ProductController::class, 'saveEdit']);

    Route::get('chi-tiet/{id}', [ProductController::class, 'detail'])->name('product.detail');

    Route::get('xoa/{id}', [ProductController::class, 'remove'])->name('product.remove');
    // Route::get('xoa/{id}', [ProductController::class, 'remove'])->middleware('permission:remove product')->name('product.remove');
});

?>
