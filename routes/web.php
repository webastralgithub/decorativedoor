<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\admin\DashboardController;
use \App\Http\Controllers\admin\ClientController;
use \App\Http\Controllers\admin\FinancierController;
use \App\Http\Controllers\admin\FournisseurController;
use \App\Http\Controllers\admin\ProjetsController;
use \App\Http\Controllers\admin\ParamètreController;
use \App\Http\Controllers\admin\StatistiquesController;
use \App\Http\Controllers\admin\UtilisateursController;
use \App\Http\Controllers\admin\ErrorController;

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

Route::get('/admin', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return view('auth.login');
    }
});

Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('/product/{ProductName}', [App\Http\Controllers\ShopController::class, 'product_details'])->name('product');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::get('/category/{CategoryName}', [App\Http\Controllers\ShopController::class, 'product_details'])->name('product_category');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'roles' => \App\Http\Controllers\RoleController::class,
        'users' => \App\Http\Controllers\UserController::class,
        'products' => \App\Http\Controllers\ProductController::class,
        'category' =>  \App\Http\Controllers\CategoryController::class
    ]);
});
