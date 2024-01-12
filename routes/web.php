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
use App\Http\Controllers\CustomerController;
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
Route::middleware(['auth', 'isAdminWebAccess'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/product/{slug}', [ShopController::class, 'product_details'])->name('product');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/start-new-order', [HomeController::class, 'startneworder'])->name('neworder');
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
    Route::post('/check-user', [CustomerController::class, 'checkuser'])->name('checkuser');
    Route::post('/store-customer', [CustomerController::class, 'store'])->name('store-customer');

    // Route::get('/product-details/{CategoryName}', [ShopController::class, 'product_details'])->name('product_category');
    Route::get('cart', [ShopController::class, 'cart'])->name('cart');
    Route::get('category/{slug}', [ShopController::class, 'category'])->name('category');

    Route::post('add-to-cart', [ShopController::class, 'addToCart'])->name('add.to.cart');

    Route::patch('update-cart', [ShopController::class, 'update_cart'])->name('update.cart');
    Route::patch('add_on', [ShopController::class, 'addOn'])->name('add_on.cart');
    Route::delete('remove-from-cart', [ShopController::class, 'remove_cart'])->name('remove.from.cart');
    Route::post('checkout', [ShopController::class, 'checkout'])->name('checkout');
    Route::get('get_price', [ShopController::class, 'get_price'])->name('get.price');
    Route::Post('share-product/{id}', [ShopController::class, 'share_product'])->name('share-product');
    Route::Post('discount/{id}',[ShopController::class, 'product_discount'])->name('discount');

});

Route::middleware(['auth', 'isAdminAccess'])->prefix('admin')->group(function () {
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
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/update/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/details/{order_id}/download', [OrderController::class, 'downloadInvoice'])->name('order.downloadInvoice');
    Route::post('/update-order-status', [OrderController::class, 'updateStatus']);
    Route::post('/update-product-status', [OrderController::class, 'updateProductStatus']);
    Route::post('/update-order-product-status', [OrderController::class, 'updateorderProductStatus']);
    Route::get('/delivery-user/{id}', [OrderController::class, 'delivery_user'])->name('orders.delivery_user');
    Route::post('/delivery-user-save', [OrderController::class, 'delivery_user_save'])->name('orders.delivery_user_save');
    Route::post('/update-user-address', [UserController::class, 'createAddress']);
    Route::get('/assembler-order', [OrderController::class, 'assembler_order'])->name('update-product-status');
    Route::Post('/add-assembler-note', [OrderController::class, 'add_assembler_note'])->name('order.add_assembler_note');
    
    Route::get('/deliverie', [DeliveriesController::class, 'index'])->name('deliveries');
    Route::get('/deliveries/track', [DeliveriesController::class, 'orderTrack'])->name('order.track');
    Route::post('deliveries/track/order', [DeliveriesController::class, 'deliveryTrackOrder'])->name('delivery.track.order');
});
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.order');
