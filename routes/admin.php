<?php

use App\Http\Controllers\Admin\BookController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
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
    Route::get('detail/{id}', [CategoryController::class, 'detail'])->name('category.detail');
    Route::get('xoa/{id}', [CategoryController::class, 'remove'])->name('category.remove');
    Route::get('tao-moi', [CategoryController::class, 'addForm'])->name('category.add');
    Route::post('tao-moi', [CategoryController::class, 'saveAdd']);
    Route::get('cap-nhat/{id}', [CategoryController::class, 'editForm'])->name('category.edit');
    Route::post('cap-nhat/{id}', [CategoryController::class, 'saveEdit']);
});

Route::prefix('sach')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('book.index');
    Route::delete('xoa/{id}', [BookController::class, 'remove'])->name('book.remove');
    Route::get('tao-moi', [BookController::class, 'addForm'])->name('book.add');
    Route::post('tao-moi', [BookController::class, 'saveAdd'])->name('book.saveAdd');
    Route::get('cap-nhat/{id}', [BookController::class, 'editForm'])->name('book.edit');
    Route::post('cap-nhat/{id}', [BookController::class, 'saveEdit'])->name('book.saveEdit');
    Route::get('chi-tiet/{id}', [BookController::class, 'detail'])->name('book.detail');
    Route::post('upload', [BookController::class, 'upload'])->name('book.upload');
    Route::get('dataBook', [BookController::class, 'getData'])->name('book.filter');
});

Route::prefix('san-pham')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('xoa/{id}', [ProductController::class, 'remove'])->middleware('permission:remove product')->name('product.remove');

    Route::middleware('permission:add product')->group(function () {
        Route::get('tao-moi', [ProductController::class, 'addForm'])->name('product.add');
        Route::post('tao-moi', [ProductController::class, 'saveAdd']);
        Route::get('cap-nhat/{id}', [ProductController::class, 'editForm'])->name('product.edit');
        Route::post('cap-nhat/{id}', [ProductController::class, 'saveEdit']);
    });
});