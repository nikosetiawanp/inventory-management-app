<?php

use App\Http\Controllers\Api\V1\InventoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\PurchaseController;
use App\Http\Controllers\Api\V1\VendorController;
use App\Http\Controllers\Api\V1\PurchaseItemController;
use App\Http\Controllers\Api\V1\InventoryItemController;
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
    Route::apiResource('purchase-items', PurchaseItemController::class);
    Route::apiResource('inventories', InventoryController::class);
    Route::apiResource('inventory-items', InventoryItemController::class);

    Route::post('purchase-items/bulk', ['uses' => 'PurchaseItemController@bulkStore']);
    Route::post('inventory-items/bulk', ['uses' => 'InventoryItemController@bulkStore']);
});
