<?php
// 192.168.0.29

use App\Http\Controllers\API\CustomerAuthController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ReviewController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('products',ProductController::class);

Route::prefix('customer')->group(function () {
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::post('/login', [CustomerAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [CustomerAuthController::class, 'logout']);
        Route::get('/profile', [CustomerAuthController::class, 'profile']);
    });
});
Route::post('/update-profile-image/{UserId}', [CustomerAuthController::class, 'updateProfileImage'])
    ->middleware('api');


// Route::post('/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');
Route::post('/orders', [OrderController::class, 'store']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('orders', OrderController::class)->only(['store']);
// });

Route::post('/orders/{order}/payment', [PaymentController::class, 'processPayment']);

Route::get('/users/{user}/orders', [OrderController::class, 'getUserOrders']);



Route::prefix('merchants')->group(function () {
    // Routes بدون مصادقة
    Route::post('/register', [MerchantController::class, 'register']);
    Route::post('/login', [MerchantController::class, 'login']);

    // Routes تحتاج مصادقة
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [MerchantController::class, 'index']);
        Route::get('/{merchant}', [MerchantController::class, 'show']);
        Route::put('/{merchant}', [MerchantController::class, 'update']);
        Route::delete('/{merchant}', [MerchantController::class, 'destroy']);
        Route::post('/logout', [MerchantController::class, 'logout']);
    });
});


Route::prefix('reviews')->group(function () {
    Route::get('/product/{productId}', [ReviewController::class, 'getReviewsByProductId']);
    Route::post('/', [ReviewController::class, 'addReview']);
    Route::get('/{id}', [ReviewController::class, 'show']);
    Route::put('/{id}', [ReviewController::class, 'update']);
    Route::delete('/{id}', [ReviewController::class, 'destroy']);
});



use App\Http\Controllers\Api\MerchantDocumentController;
use App\Http\Controllers\Api\MerchantOrderController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PasswordResetController;

Route::prefix('merchant')->group(function () {
    Route::apiResource('documents', MerchantDocumentController::class);
    
    // أو تحديد الطرق يدوياً
    Route::post('/documents', [MerchantDocumentController::class, 'store']);
    Route::get('/documents/{document}/status', [MerchantDocumentController::class, 'checkStatus']);
});

Route::prefix('merchant')->group(function () {
    // جلب وثيقة التاجر الأخيرة
    Route::get('/{merchantId}/document', [MerchantDocumentController::class, 'show']);
    
    // جلب جميع وثائق التاجر
    Route::get('/{merchantId}/documents', [MerchantDocumentController::class, 'index']);
});


Route::prefix('products')->group(function () {
    Route::get('/merchant/{merchantId}', [ProductController::class, 'indexId']);
    Route::post('/', [ProductController::class, 'store']);
});


Route::prefix('merchant')->group(function () {
    Route::get('/{merchantId}/orders', [MerchantOrderController::class, 'getMerchantOrders']);
});
// Route::put('/products/{id}', [ProductController::class, 'update'])->withoutMiddleware(['auth:sanctum']);
// Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::post('/products/{id}', [ProductController::class, 'update'])
    ->withoutMiddleware(['auth:sanctum']);


    Route::post('customs/{id}/update-image', [CustomerAuthController::class, 'updateImage']);
    Route::get('customs/{id}/image', [CustomerAuthController::class, 'getCustomerImage']);
    Route::post('customer/{id}/update', [CustomerAuthController::class, 'updateProfile']);
    // routes/api.php
Route::post('forgot-password', [CustomerAuthController::class, 'forgotPassword']);
Route::post('reset-password', [CustomerAuthController::class, 'resetPassword']);

Route::post('/password/send-code', [PasswordResetController::class, 'sendVerificationCode']);
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);

// routes/api.php
Route::post('/password-reset-request', [PasswordResetController::class, 'store']);


Route::post('/notifications', [NotificationController::class, 'index']);
    // إدارة الإشعارات
    // Route::get('/notifications', [NotificationController::class, 'index']);
    // Route::get('/notifications/{notification}', [NotificationController::class, 'show']);
    // Route::put('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);


Route::group(['prefix' => 'merchant'], function() {
    Route::get('/{merchantId}/reviews', [ReviewController::class, 'getMerchantProductReviews']);
    Route::get('/{merchantId}/reviews/filter', [ReviewController::class, 'filterMerchantReviews']);
});
