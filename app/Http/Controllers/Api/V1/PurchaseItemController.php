<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StorePurchaseItemRequest;
use App\Http\Requests\V1\UpdatePurchaseItemRequest;
use App\Http\Requests\V1\BulkStorePurchaseItemRequest;
use App\Http\Resources\V1\PurchaseItemCollection;
use App\Http\Resources\V1\PurchaseItemResource;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;


class PurchaseItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $purchaseId = $request->input("purchaseId");
        return new PurchaseItemCollection(PurchaseItem::where('purchase_id', $purchaseId)->with(['product'])->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function bulkStore(BulkStorePurchaseItemRequest $request)
    {
        $bulk = collect($request->all())->map(function ($arr, $key) {
            return Arr::except($arr, ["purchaseId", "productId"]);
        });

        PurchaseItem::insert($bulk->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseItemRequest $request)
    {
        return new PurchaseItemResource(PurchaseItem::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseItem $purchaseItem)
    {
        $purchaseItem->load('product');
        return new PurchaseItemResource($purchaseItem);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseItemRequest $request, PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseItem $purchaseItem)
    {
        //
    }
}
