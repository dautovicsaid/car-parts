<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserAuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function ($router) {

    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::get('user', [UserAuthController::class, 'user']);
    Route::post('logout', [UserAuthController::class, 'logout']);

    Route::get('brands', [BrandController::class, 'index']);
    Route::post('brands', [BrandController::class, 'create']);
    Route::get('brands/{brand}', [BrandController::class, 'get']);
    Route::put('brands/{brand}', [BrandController::class, 'update']);
    Route::delete('brands/{brand}', [BrandController::class, 'delete']);

    Route::get('car-models', [CarModelController::class, 'index']);
    Route::post('car-models', [CarModelController::class, 'create']);
    Route::get('car-models/{carModel}', [CarModelController::class, 'get']);
    Route::put('car-models/{carModel}', [CarModelController::class, 'update']);
    Route::delete('car-models/{carModel}', [CarModelController::class, 'delete']);
    Route::get('brands/{id}/car-models', [CarModelController::class, 'getCarModelsByBrand']);

    Route::get('product-categories', [ProductCategoryController::class, 'index']);
    Route::post('product-categories', [ProductCategoryController::class, 'create']);
    Route::get('product-categories/{productCategory}', [ProductCategoryController::class, 'get']);
    Route::put('product-categories/{productCategory}', [ProductCategoryController::class, 'update']);
    Route::delete('product-categories/{productCategory}', [ProductCategoryController::class, 'delete']);

    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'create']);
    Route::get('products/{product}', [ProductController::class, 'get']);
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'delete']);

    Route::post('products/{id}/add-to-cart', [OrderController::class, 'addToCart']);
    Route::patch('orders/{order}/complete', [OrderController::class, 'completeOrder']);
    Route::get('cart', [OrderController::class, 'getCart']);
    Route::put('orders/{order}/items/{orderItem}', [OrderController::class, 'updateOrderItem']);
    Route::delete('orders/{order}/items/{orderItem}', [OrderController::class, 'deleteOrderItem']);
    Route::get('orders/me', [OrderController::class, 'getAuthUserOrders']);

});
