<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MenController;
use App\Http\Controllers\WomenController;
use App\Http\Controllers\KidController;
use App\Models\Kid;
use App\Models\Men;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
});


Route::group(['prefix' => 'category'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category');
    Route::post('/save', [CategoryController::class, 'save'])->name('category.save');
    Route::any('/form', [CategoryController::class, 'form'])->name('category.form');
    Route::post('/list', [CategoryController::class, 'list'])->name('category.list');
    Route::post('/view', [CategoryController::class, 'view'])->name('category.view');
    Route::post('/delete', [CategoryController::class, 'delete'])->name('category.delete');
    Route::post('/restore', [CategoryController::class, 'restore'])->name('category.restore');
});

Route::group(['prefix' => 'product'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('product');
    Route::post('/save', [ProductController::class, 'save'])->name('product.save');
    Route::any('/form', [ProductController::class, 'form'])->name('product.form');
    Route::post('/list', [ProductController::class, 'list'])->name('product.list');
    Route::post('/view', [ProductController::class, 'view'])->name('product.view');
    Route::post('/delete', [ProductController::class, 'delete'])->name('product.delete');
    Route::post('/restore', [ProductController::class, 'restore'])->name('product.restore');
});
Route::group(['prefix' => 'customer'], function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customer');
    Route::post('/save', [CustomerController::class, 'save'])->name('customer.save');
    Route::any('/form', [CustomerController::class, 'form'])->name('customer.form');
    Route::post('/list', [CustomerController::class, 'list'])->name('customer.list');
    Route::post('/view', [CustomerController::class, 'view'])->name('customer.view');
    Route::post('/delete', [CustomerController::class, 'delete'])->name('customer.delete');
    Route::post('/restore', [CustomerController::class, 'restore'])->name('customer.restore');
});

Route::group(['prefix' => 'order'], function () {
    Route::get('/', [OrderController::class, 'index'])->name('order');
    Route::post('/save', [OrderController::class, 'save'])->name('order.save');
    Route::any('/form', [OrderController::class, 'form'])->name('order.form');
    Route::post('/list', [OrderController::class, 'list'])->name('order.list');
    Route::post('/view', [OrderController::class, 'view'])->name('order.view');
    Route::post('/delete', [OrderController::class, 'delete'])->name('order.delete');
    Route::post('/restore', [OrderController::class, 'restore'])->name('order.restore');
});

Route::group(['prefix' => 'front'], function () {
    Route::get('/home', [HomePageController::class, 'index'])->name('frontend.index');
    Route::get('/product', [HomePageController::class, 'product'])->name('frontend.product');
    Route::get('/productDetails', [HomePageController::class, 'productDetails'])->name('frontend.productDetails');
    Route::get('/cart', [HomePageController::class, 'cart'])->name('frontend.cart');
    Route::get('/signup', [HomePageController::class, 'signup'])->name('frontend.signup');
    Route::get('/login', [HomePageController::class, 'login'])->name('frontend.login');
    Route::get('/men', [MenController::class, 'men'])->name('frontend.men');
    Route::get('/women', [WomenController::class, 'women'])->name('frontend.women');
    Route::get('/kid', [KidController::class, 'kid'])->name('frontend.kid');
});
