<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BreedController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AccessoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\UploadController;

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
    Route::delete('xoa/{id}', [UserController::class, 'remove'])->name('user.remove');
    Route::get('tao-moi', [UserController::class, 'addForm'])->name('user.add');
    Route::post('tao-moi', [UserController::class, 'saveAdd'])->name('user.saveAdd');
    Route::get('cap-nhat/{id}', [UserController::class, 'editForm'])->name('user.edit');
    Route::post('cap-nhat/{id}', [UserController::class, 'saveEdit'])->name('user.saveEdit');
    Route::get('ho-so/{id}', [UserController::class, 'proFile'])->name('user.profile');
    Route::get('doi-mat-khau/{id}', [UserController::class, 'changePForm'])->name('user.changeP');
    Route::post('doi-mat-khau/{id}', [UserController::class, 'saveChangeP']);
    Route::get('dataUser', [UserController::class, 'getData'])->name('user.filter');
});

Route::prefix('danh-muc')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');

    Route::get('tao-moi', [CategoryController::class, 'addForm'])->name('category.add');
    Route::post('tao-moi', [CategoryController::class, 'saveAdd'])->name('category.saveAdd');

    Route::get('cap-nhat/{id}', [CategoryController::class, 'editForm'])->name('category.edit');
    Route::post('cap-nhat/{id}', [CategoryController::class, 'saveEdit'])->name('category.saveEdit');

    Route::get('chi-tiet/{id}', [CategoryController::class, 'detail'])->name('category.detail');

    Route::delete('xoa/{id}', [CategoryController::class, 'remove'])->name('category.remove');
    Route::get('dataCate', [CategoryController::class, 'getData'])->name('category.filter');
    Route::get('trash', [CategoryController::class, 'backUp'])->name('category.backup');
    Route::get('dataBackUp', [CategoryController::class, 'getBackUp'])->name('category.getBackup');
    Route::get('trash/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
    Route::delete('trash/deleteForver/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    Route::delete('trash/remove', [CategoryController::class, 'removeMultiple'])->name('category.removeMul');
    Route::get('trash/restore', [CategoryController::class, 'restoreMultiple'])->name('category.restoreMul');
    Route::delete('trash/deleteForeverMul', [CategoryController::class, 'deleteMultiple'])->name('category.deleteMul');
});

Route::prefix('don-hang')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order.index');

    Route::get('cap-nhat', [OrderController::class, 'editForm'])->name('order.edit');
    // Route::get('cap-nhat/{id}', [OrderController::class, 'editForm'])->name('order.edit');
    Route::post('cap-nhat/{id}', [OrderController::class, 'saveEdit']);;

    Route::get('chi-tiet/{id}', [OrderController::class, 'detail'])->name('order.detail');

    Route::get('xoa/{id}', [OrderController::class, 'remove'])->name('order.remove');
});

Route::prefix('giong-loai')->group(function () {
    Route::get('/', [BreedController::class, 'index'])->name('breed.index');

    Route::get('tao-moi', [BreedController::class, 'addForm'])->name('breed.add');
    Route::post('tao-moi', [BreedController::class, 'saveAdd'])->name('breed.saveAdd');

    Route::get('cap-nhat/{id}', [BreedController::class, 'editForm'])->name('breed.edit');
    Route::post('cap-nhat/{id}', [BreedController::class, 'saveEdit'])->name('breed.saveEdit');

    Route::get('chi-tiet/{id}', [BreedController::class, 'detail'])->name('breed.detail');

    Route::get('xoa/{id}', [BreedController::class, 'remove'])->name('breed.remove');
    Route::get('dataPet', [BreedController::class, 'getData'])->name('breed.filter');
});

Route::prefix('san-pham')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');

    Route::get('tao-moi', [ProductController::class, 'addForm'])->name('product.add');
    Route::post('tao-moi', [ProductController::class, 'saveAdd'])->name('product.saveAdd');

    Route::get('cap-nhat/{id}', [ProductController::class, 'editForm'])->name('product.edit');
    Route::post('cap-nhat/{id}', [ProductController::class, 'saveEdit'])->name('product.saveEdit');

    Route::get('chi-tiet/{id}', [ProductController::class, 'detail'])->name('product.detail');

    Route::delete('xoa/{id}', [ProductController::class, 'remove'])->name('product.remove');

    Route::get('dataProduct', [ProductController::class, 'getData'])->name('product.filter');
    Route::get('trash', [ProductController::class, 'backUp'])->name('product.backup');
    Route::get('dataBackUp', [ProductController::class, 'getBackUp'])->name('product.getBackup');
    Route::get('trash/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
    Route::delete('trash/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    Route::post('import', [ProductController::class, 'store'])->name('product.import');
    Route::delete('trash/remove', [ProductController::class, 'removeMultiple'])->name('product.removeMul');
});

Route::prefix('phu-kien')->group(function () {
    Route::get('/', [AccessoryController::class, 'index'])->name('accessory.index');

    Route::get('tao-moi', [AccessoryController::class, 'addForm'])->name('accessory.add');
    Route::post('tao-moi', [AccessoryController::class, 'saveAdd'])->name('accessory.saveAdd');

    Route::get('cap-nhat/{id}', [AccessoryController::class, 'editForm'])->name('accessory.edit');
    Route::post('cap-nhat/{id}', [AccessoryController::class, 'saveEdit'])->name('accessory.saveEdit');

    Route::get('chi-tiet/{id}', [AccessoryController::class, 'detail'])->name('accessory.detail');

    Route::get('xoa/{id}', [AccessoryController::class, 'remove'])->name('accessory.remove');
    // Route::get('xoa/{id}', [AccessoryController::class, 'remove'])->middleware('permission:remove product')->name('product.remove');
});

Route::prefix('giam-gia')->group(function () {
    Route::get('/', [CouponController::class, 'index'])->name('coupon.index');

    Route::get('tao-moi', [CouponController::class, 'addForm'])->name('coupon.add');
    Route::post('tao-moi', [CouponController::class, 'saveAdd'])->name('coupon.saveAdd');

    Route::get('cap-nhat/{id}', [CouponController::class, 'editForm'])->name('coupon.edit');
    Route::post('cap-nhat/{id}', [CouponController::class, 'saveEdit'])->name('coupon.saveEdit');

    Route::get('chi-tiet/{id}', [CouponController::class, 'detail'])->name('coupon.detail');

    Route::get('xoa/{id}', [CouponController::class, 'remove'])->name('coupon.remove');

    Route::get('dataCoupon', [CouponController::class, 'getData'])->name('coupon.filter');
});

Route::prefix('tin-tuc')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');

    Route::get('tao-moi', [BlogController::class, 'addForm'])->name('blog.add');
    Route::post('tao-moi', [BlogController::class, 'saveAdd'])->name('blog.saveAdd');

    Route::get('cap-nhat/{id}', [BlogController::class, 'editForm'])->name('blog.edit');
    Route::post('cap-nhat/{id}', [BlogController::class, 'saveEdit'])->name('blog.saveEdit');

    Route::get('chi-tiet/{id}', [BlogController::class, 'detail'])->name('blog.detail');

    Route::get('xoa/{id}', [BlogController::class, 'remove'])->name('blog.remove');
    Route::post('upload', [BlogController::class, 'upload'])->name('blog.upload');

    Route::get('dataBlog', [BlogController::class, 'getData'])->name('blog.filter');
});

Route::prefix('danh-muc-tin-tuc')->group(function () {
    Route::get('/', [BlogCategoryController::class, 'index'])->name('blogCategory.index');

    Route::get('tao-moi', [BlogCategoryController::class, 'addForm'])->name('blogCategory.add');
    Route::post('tao-moi', [BlogCategoryController::class, 'saveAdd'])->name('blogCategory.saveAdd');

    Route::get('cap-nhat/{id}', [BlogCategoryController::class, 'editForm'])->name('blogCategory.edit');
    Route::post('cap-nhat/{id}', [BlogCategoryController::class, 'saveEdit'])->name('blogCategory.saveEdit');

    Route::get('xoa/{id}', [BlogCategoryController::class, 'remove'])->name('blogCategory.remove');

    Route::get('dataBlogCategory', [BlogCategoryController::class, 'getData'])->name('blogCategory.filter');
});

Route::prefix('thong-tin-he-thong')->group(function () {
    Route::get('/', [GeneralSettingController::class, 'index'])->name('generalSetting.index');

    Route::post('/', [GeneralSettingController::class, 'save']);

    Route::get('xoa/{id}', [GeneralSettingController::class, 'remove'])->name('generalSetting.remove');
});

Route::prefix('slide')->group(function () {
    Route::get('/', [SlideController::class, 'index'])->name('slide.index');

    Route::get('tao-moi', [SlideController::class, 'addForm'])->name('slide.add');
    Route::post('tao-moi', [SlideController::class, 'saveAdd'])->name('slide.saveAdd');

    Route::get('cap-nhat/{id}', [SlideController::class, 'editForm'])->name('slide.edit');
    Route::post('cap-nhat/{id}', [SlideController::class, 'saveEdit'])->name('slide.saveEdit');

    Route::get('chi-tiet/{id}', [SlideController::class, 'detail'])->name('slide.detail');

    Route::get('xoa/{id}', [SlideController::class, 'remove'])->name('slide.remove');
});