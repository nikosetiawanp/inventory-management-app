<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\V1\ItemResource;
use App\Models\Item;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreItemRequest;
use App\Http\Resources\V1\ItemCollection;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $purchaseId = $request->input("purchaseId");
        return new ItemCollection(Item::where('purchase_id', $purchaseId)->with(['product'])->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function bulkStore(BulkStoreItemRequest $request)
    {
        $bulk = collect($request->all())->map(function ($arr, $key) {
            return Arr::except($arr, ["purchaseId", "productId"]);
        });

        Item::insert($bulk->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        return new ItemResource(Item::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $item->load('product');
        return new ItemResource($item);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
