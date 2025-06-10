<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetRequestController;
use App\Http\Controllers\NotificationController;
Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


});

Route::resource('products', ProductController::class);
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');



Route::get('/all-products', [ProductController::class, 'showAllProducts'])
     ->name('products.all');
Route::get('/first-product', [ProductController::class, 'showFirstProduct'])->name('first.product');


Route::delete('/products/{product}', [ProductController::class, 'destroy'])
     ->name('products.destroy');
    Route::resource('products', ProductController::class);
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');



Route::resource('merchants', MerchantController::class);
Route::get('/merchants', [MerchantController::class, 'index'])->name('merchants.index');
Route::get('/merchants/create', [MerchantController::class, 'create'])->name('merchants.create');
Route::post('/merchants/create/stor', [MerchantController::class, 'store'])->name('merchants.store');
Route::get('/{MerchantId}/edit', [MerchantController::class, 'edit'])->name('merchants.edit');
Route::put('/{MerchantId}', [MerchantController::class, 'update'])->name('merchants.update');
Route::delete('/{MerchantId}', [MerchantController::class, 'destroy'])->name('merchants.destroy');


Route::resource('documents', DocumentController::class);
Route::post('/documents/create/stor', [DocumentController::class, 'store'])->name('documents.store');
Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
Route::resource('merchants.documents', DocumentController::class)
    ->parameters(['documents' => 'document'])
    ->shallow();


Route::resource('custom', CustomController::class);


Route::resource('orders', OrderController::class);



// Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
// Route::get('/carts/create', [CartController::class, 'create'])->name('cart.create');
// Route::get('/{carts}', [CartController::class, 'show'])->name('carts.show');
// Route::post('/carts', [CartController::class, 'store'])->name('cart.store');
// Route::get('/{carts}/carts/edit', [CartController::class, 'edit'])->name('carts.edit');
// Route::put('/carts/{carts}', [CartController::class, 'update'])->name('cart.update');
// Route::delete('/{carts}/carts/index', [CartController::class, 'destroy'])->name('cart.destroy');
Route::group(['prefix' => 'carts', 'as' => 'carts.'], function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::get('/create', [CartController::class, 'create'])->name('create');
    Route::post('/', [CartController::class, 'store'])->name('store');
    Route::get('/{cart}', [CartController::class, 'show'])->name('show');
    Route::get('/{cart}/edit', [CartController::class, 'edit'])->name('edit');
    Route::put('/{cart}', [CartController::class, 'update'])->name('update');
    Route::delete('/{cart}', [CartController::class, 'destroy'])->name('destroy');
});

// Route::group(['prefix' => 'payments', 'as' => 'payments.'], function () {
//     Route::get('/', [PaymentController::class, 'index'])->name('index');
// });
Route::resource('payments', PaymentController::class);
// Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
// Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
// Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
// Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
// Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
// Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
// Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');


// Route::get('/reports/daily-sales', [ReportController::class, 'dailySales'])->name('reports.daily');
// Route::get('/reports/download-pdf', [ReportController::class, 'downloadPDF'])->name('reports.download');


Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/daily', [ReportController::class, 'dailySales'])->name('reports.daily');
    Route::get('/daily/download', [ReportController::class, 'downloadPDF'])->name('reports.download');
    Route::get('/low-stock', [ReportController::class, 'lowStock'])->name('reports.low-stock');
    Route::get('/low-stock/download', [ReportController::class, 'downloadLowStockPDF'])->name('reports.download-low-stock');
});


Route::get('/reset-password', function (Request $request) {
    $token = $request->query('token');
    
    return view('auth.reset-password', [
        'token' => $token
    ]);
})->name('password.reset');

Route::middleware(['auth'])->group(function () {
    Route::get('/password-reset-requests', [PasswordResetController::class, 'index'])
         ->name('password-reset-requests.index');
         
    Route::put('/password-reset-requests/{id}', [PasswordResetController::class, 'update'])
         ->name('password-reset-requests.update');
});


Route::prefix('admin')->middleware(['auth'])->group(function () {
    // ... روابط أخرى
    
    Route::resource('notifications', \App\Http\Controllers\NotificationController::class)
        ->except(['show'])
        ->names([
            'index' => 'admin.notifications.index',
            'create' => 'admin.notifications.create',
            'store' => 'admin.notifications.store',
            'edit' => 'admin.notifications.edit',
            'update' => 'admin.notifications.update',
            'destroy' => 'admin.notifications.destroy'
        ]);

    Route::get('notifications/create-all', [\App\Http\Controllers\NotificationController::class, 'createAll'])
        ->name('admin.notifications.create-all');
        
    Route::post('notifications/store-all', [\App\Http\Controllers\NotificationController::class, 'storeAll'])
        ->name('admin.notifications.store-all');
});

// use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
require __DIR__.'/auth.php';



