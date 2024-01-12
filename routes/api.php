<?php

use App\Http\Controllers\Api\V1\InventoryHistoryController;
use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\PurchaseController;
use App\Http\Controllers\Api\V1\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::apiResource('vendors', VendorController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('purchases', PurchaseController::class);
    Route::apiResource('items', ItemController::class);
    Route::apiResource('inventoryhistories', InventoryHistoryController::class);

    Route::post('items/bulk', ['uses' => 'ItemController@bulkStore']);
});
