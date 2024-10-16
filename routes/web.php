<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\CartController;
use App\Http\Middleware\user;

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
    Route::get('/second', [DashboardController::class, 'secondDashboard'])->name('admin.secondDashboard');
});

Route::group(['prefix' => 'dashboardlogin'], function () {
    Route::get('/', [UserAccountController::class, 'adminLogin'])->name('admin.login');
    Route::post('/adminCheck', [UserAccountController::class, 'adminCheck'])->name('admin.check');
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
    Route::post('/list', [ProductController::class, 'list'])->name('product.list');
    Route::post('/view', [ProductController::class, 'view'])->name('product.view');
    Route::post('/delete', [ProductController::class, 'delete'])->name('product.delete');
    Route::any('/form', [ProductController::class, 'form'])->name('product.form');
    Route::get('/menProducts', [ProductController::class, 'menProducts'])->name('frontend.men');
    Route::get('/womenProducts', [ProductController::class, 'womenProducts'])->name('frontend.women');
    Route::get('/kidProducts', [ProductController::class, 'kidProducts'])->name('frontend.kid');
    Route::get('/searchProducts', [ProductController::class, 'searchProducts'])->name('frontend.search');
});

// Route::group(['prefix' => 'customer'], function () {
//     Route::get('/', [CustomerController::class, 'index'])->name('customer');
// });


Route::group(['prefix' => 'front'], function () {
    Route::group(['prefix' => 'frontpanel'], function () {
        Route::get('/home', [HomePageController::class, 'index'])->name('frontend.index');
        Route::get('/product', [HomePageController::class, 'product'])->name('frontend.product');
        Route::any('/productDetails/{id}', [HomePageController::class, 'productDetails'])->name('frontend.productDetails');
        Route::get('/signup', [HomePageController::class, 'signup'])->name('frontend.signup');
        Route::get('/login', [HomePageController::class, 'login'])->name('frontend.login');
        Route::get('/userdetails', [HomePageController::class, 'userdetails'])->name('frontend.userdetails')->middleware(user::class);
    });

    Route::group(['prefix' => 'useraccount'], function () {
        Route::post('/signup', [UserAccountController::class, 'signup'])->name('signup');
        Route::post('/logincheck', [UserAccountController::class, 'loginCheck'])->name('logincheck');
        Route::get('/logout', [UserAccountController::class, 'logout'])->name('logout');
        Route::get('/', [UserAccountController::class, 'index'])->name('customer');

        Route::post('/save', [UserAccountController::class, 'save'])->name('customer.save');
        Route::post('/list', [UserAccountController::class, 'list'])->name('customer.list');
    });

    Route::group(['prefix' => 'order'], function () {
        Route::post('/save', [OrderController::class, 'save'])->name('order.save');
        Route::post('/index', [OrderController::class, 'list'])->name('order.list');
        Route::post('/update', [OrderController::class, 'updateStatus'])->name('order.update');
        Route::get('/orderDetails', [OrderController::class, 'orderDetails'])->name('order.details')->middleware(user::class);
    });

    Route::group(['prefix' => 'cart'], function () {
        Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
        Route::get('/cart', [CartController::class, 'showCart'])->name('listAddtocart')->middleware(user::class);
        Route::post('/remove-from-cart', [CartController::class, 'removefromCart'])->name('removeFromCart');
    });
});