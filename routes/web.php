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
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderCompleteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderPendingController;

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
        return redirect()->route('home');
    } else {
        return view('auth.login');
    }
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [App\Http\Controllers\ShopController::class, 'product_details'])->name('product');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
// Route::get('/product-details/{CategoryName}', [App\Http\Controllers\ShopController::class, 'product_details'])->name('product_category');
Route::get('cart', [\App\Http\Controllers\ShopController::class, 'cart'])->name('cart');
Route::get('category/{slug}', [\App\Http\Controllers\ShopController::class, 'category'])->name('category');

Route::post('add-to-cart', [\App\Http\Controllers\ShopController::class, 'addToCart'])->name('add.to.cart');

Route::patch('update-cart', [\App\Http\Controllers\ShopController::class, 'update_cart'])->name('update.cart');
Route::patch('add_on', [\App\Http\Controllers\ShopController::class, 'addOn'])->name('add_on.cart');
Route::delete('remove-from-cart', [\App\Http\Controllers\ShopController::class, 'remove_cart'])->name('remove.from.cart');
Route::post('checkout', [\App\Http\Controllers\ShopController::class, 'checkout'])->name('checkout');
Route::get('get_price', [\App\Http\Controllers\ShopController::class, 'get_price'])->name('get.price');
Route::middleware(['auth'])->prefix('admin')->group(function () {
    //dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'roles' => \App\Http\Controllers\RoleController::class,
        'users' => \App\Http\Controllers\UserController::class,
        'products' => \App\Http\Controllers\ProductController::class,
        'inventory' => \App\Http\Controllers\InventoryController::class,
        'category' =>  \App\Http\Controllers\CategoryController::class,
        'permissions' =>  \App\Http\Controllers\PermissionController::class,
        // 'orders' =>  \App\Http\Controllers\OrderController::class
    ]);

    // Route Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/pending', OrderPendingController::class)->name('orders.pending');
    Route::get('/orders/complete', OrderCompleteController::class)->name('orders.complete');

    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

    // SHOW ORDER
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/update/{order}', [OrderController::class, 'update'])->name('orders.update');

    // TODO: Remove from OrderController
    Route::get('/orders/details/{order_id}/download', [OrderController::class, 'downloadInvoice'])->name('order.downloadInvoice');
    Route::post('/update-order-status', [OrderController::class, 'updateStatus']);

    // Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    // Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    // Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');

    // //Route::get('/purchases/show/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    // Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');

    // //Route::get('/purchases/edit/{purchase}', [PurchaseController::class, 'edit'])->name('purchases.edit');
    // Route::get('/purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');

    // Route::put('/purchases/update/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
    // Route::delete('/purchases/delete/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.delete');
});
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.order');
