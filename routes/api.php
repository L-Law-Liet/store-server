<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\FeedbacksController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:api'])->group(function (){
    Route::post('/auth', function (Request $request) {
        return $request->user();
    });

    Route::post('user/avatar/{id}', [UserController::class, 'setAvatar']);
    Route::post('user/bill/{user}', [UserController::class, 'bill']);
    Route::post('user/{user}/order', [CheckoutController::class, 'makeOrder']);
    Route::get('user/{user}/order', [CheckoutController::class, 'getOrders']);
    Route::get('user/{user}/products/{product}', [FeedbacksController::class, 'checkAccess']);
});
Route::get('news/pageable', [NewsController::class, 'getPageable']);
Route::get('products/pageable', [ProductController::class, 'getProductsPageable']);

Route::get('category/{id}/products', [ProductController::class, 'getProductsByCategoryId']);
Route::get('u', function (){
   dd(\Illuminate\Support\Facades\Auth::user());
});
//Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
Auth::routes();
Route::get('products/{product}/feedbacks', [FeedbacksController::class, 'index']);
Route::post('feedbacks', [FeedbacksController::class, 'store']);
Route::get('products/{product}/feedbacks', [FeedbacksController::class, 'index']);
Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('news', NewsController::class);
Route::apiResource('users/{user}/carts', CartController::class);
Route::apiResource('users/{user}/favourites', FavouriteController::class);
Route::apiResource('users', UserController::class)->only(['update']);

