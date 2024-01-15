<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreInventoryHistoryRequest;
use App\Http\Requests\V1\UpdateInventoryHistoryRequest;
use App\Http\Resources\V1\InventoryHistoryCollection;
use App\Http\Resources\V1\InventoryHistoryResource;
use App\Models\InventoryHistory;
use Illuminate\Http\Request;

class InventoryHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");
        $type = $request->input("type");

        return new InventoryHistoryCollection(InventoryHistory::whereBetween('date', [$startDate, $endDate])
            ->where('type', $type)
            ->with(['purchase.vendor', 'product'])
            ->paginate());
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
    public function store(StoreInventoryHistoryRequest $request)
    {
        return new InventoryHistoryResource(InventoryHistory::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryHistory $inventoryHistory)
    {
        return new InventoryHistoryResource($inventoryHistory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryHistory $inventoryHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryHistoryRequest $request, InventoryHistory $inventoryHistory)
    {
        $inventoryHistory->update($request->all());
        return new InventoryHistoryResource($inventoryHistory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryHistory $inventoryHistory)
    {
        if ($inventoryHistory) {
            $inventoryHistory->delete();
        }
    }
}
