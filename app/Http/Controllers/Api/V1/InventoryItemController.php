<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreInventoryItemRequest;
use App\Http\Requests\V1\UpdateInventoryItemRequest;
use App\Http\Resources\V1\InventoryItemCollection;
use App\Http\Resources\V1\InventoryItemResource;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return new InventoryHistoryItemCollection(InventoryHistoryItem::paginate());
        $inventoryId = $request->input("inventoryId");
        return new InventoryItemCollection(InventoryItem::where('inventory_id', $inventoryId)->with(['product'])->get());
        // return new PurchaseItemCollection(PurchaseItem::where('purchase_id', $purchaseId)->with(['product'])->paginate());

        // return new InventoryItemResource(InventoryItem::with());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryItemRequest $request)
    {
        return new InventoryItemResource(InventoryItem::create($request->all()));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        //
    }
}
