<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DeliveriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderCompleteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderPendingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [ShopController::class, 'product_details'])->name('product');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Route::get('/product-details/{CategoryName}', [ShopController::class, 'product_details'])->name('product_category');
Route::get('cart', [ShopController::class, 'cart'])->name('cart');
Route::get('category/{slug}', [ShopController::class, 'category'])->name('category');

Route::post('add-to-cart', [ShopController::class, 'addToCart'])->name('add.to.cart');

Route::patch('update-cart', [ShopController::class, 'update_cart'])->name('update.cart');
Route::patch('add_on', [ShopController::class, 'addOn'])->name('add_on.cart');
Route::delete('remove-from-cart', [ShopController::class, 'remove_cart'])->name('remove.from.cart');
Route::post('checkout', [ShopController::class, 'checkout'])->name('checkout');
Route::get('get_price', [ShopController::class, 'get_price'])->name('get.price');
Route::middleware(['auth'])->prefix('admin')->group(function () {
    //dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'products' => ProductController::class,
        'inventory' => InventoryController::class,
        'category' =>  CategoryController::class,
        'permissions' =>  PermissionController::class,
        'deliveries' =>  DeliveriesController::class,
        // 'orders' =>  \App\Http\Controllers\OrderController::class
    ]);



    // Route Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/assign_user', [OrderController::class, 'assign_user'])->name('assign_user');
    Route::get('/orders/pending', OrderPendingController::class)->name('orders.pending');
    Route::get('/orders/complete', OrderCompleteController::class)->name('orders.complete');

    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/update-payment-method', [OrderController::class, 'updatePaymentMethod'])->name('orders.pay');

    // SHOW ORDER
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/update/{order}', [OrderController::class, 'update'])->name('orders.update');

    // TODO: Remove from OrderController
    Route::get('/orders/details/{order_id}/download', [OrderController::class, 'downloadInvoice'])->name('order.downloadInvoice');
    Route::post('/update-order-status', [OrderController::class, 'updateStatus']);


    Route::get('/deliverie', [DeliveriesController::class, 'index'])->name('deliveries');
    Route::get('/deliveries/track', [DeliveriesController::class, 'orderTrack'])->name('order.track');
    Route::post('deliveries/track/order', [DeliveriesController::class, 'deliveryTrackOrder'])->name('delivery.track.order');

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
