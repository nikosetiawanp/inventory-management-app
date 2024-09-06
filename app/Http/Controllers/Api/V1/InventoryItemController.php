<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreInventoryItemRequest;
use App\Http\Requests\V1\StoreInventoryItemRequest;
use App\Http\Requests\V1\UpdateInventoryItemRequest;
use App\Http\Resources\V1\InventoryItemCollection;
use App\Http\Resources\V1\InventoryItemResource;
use App\Models\InventoryItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inventoryId = $request->input("inventoryId");
        return new InventoryItemCollection(InventoryItem::where('inventory_id', $inventoryId)
            ->with(['product', 'transactionItem'])
            ->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function bulkStore(BulkStoreInventoryItemRequest $request)
    {
        // Extract common fields from each item in the bulk request
        $commonFields = collect($request->all())->map(function ($arr) {
            return Arr::except($arr, ['inventoryId', 'productId']);
        })->toArray();

        // Get product IDs from the bulk request

        // Retrieve products in bulk from the database

        // Create a new InventoryItem for each item in the bulk request
        $inventoryItems = collect($request->all())->map(function ($item) use ($commonFields) {
            // Get the associated product


            // Merge common fields with item-specific fields
            $itemFields = array_merge($commonFields, [
                'quantity' => $item['quantity'],
                'inventory_id' => $item['inventoryId'],
                'product_id' => $item['productId'],
                'transaction_item_id' => $item['transactionItemId']
            ]);

            // Create and return the new InventoryItem
            return InventoryItem::create($itemFields);
        });

        // Respond with the new InventoryItems
        return new InventoryItemCollection($inventoryItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryItemRequest $request)
    {

        // Get the associated product
        $product = Product::find($request->input('productId'));

        // Increment the quantity of the product
        $product->quantity += $request->input('quantity');
        $product->save();

        // Create a new InventoryItem with the correct stockAfter value
        $inventoryItem = InventoryItem::create([
            'quantity' => $request->input('quantity'),
            'inventory_id' => $request->input('inventoryId'),
            'product_id' => $request->input('productId'),
            'transaction_item_id' => $request->input('transactionItemId')
        ]);

        // Respond with the new InventoryItem
        return new InventoryItemResource($inventoryItem);

        //OLD
        // return new InventoryItemResource(InventoryItem::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryItemRequest $request, InventoryItem $inventoryItem)
    {
        $inventoryItem->update($request->all());
        return new InventoryItemResource($inventoryItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        //
    }
}
