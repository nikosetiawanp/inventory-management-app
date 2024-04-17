<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreInventoryRequest;
use App\Http\Requests\V1\UpdateInventoryRequest;
use App\Http\Resources\V1\InventoryResource;
use App\Http\Resources\V1\InventoryCollection;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");
        $isArrival = $request->input("isArrival");
        $transactionId = $request->input("tansactionId");

        if ($request->has('tansactionId')) {
            return new InventoryCollection(Inventory::where('tansaction_id', $transactionId)
                ->with(['inventoryItems'])
                ->get());
        } else {
            return new InventoryCollection(Inventory::whereBetween('date', [$startDate, $endDate])
                ->where('is_arrival', $isArrival)
                ->with(['tansaction.contact', 'tansaction.tansactionItems.product', 'inventoryItems'])
                ->get());
        }
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
    public function store(StoreInventoryRequest $request)
    {
        return new InventoryResource(Inventory::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {

        $inventory->update($request->all());
        return new InventoryResource($inventory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
