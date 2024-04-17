<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\BulkStoreTransactionItemRequest;
use App\Http\Requests\V1\StoreTransactionItemRequest;
use App\Http\Requests\V1\UpdateTransactionItemRequest;
use App\Http\Resources\V1\TransactionItemResource;
use App\Models\TransactionItem;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TransactionItemCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TransactionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactionId = $request->input("transactionId");
        return new TransactionItemCollection(TransactionItem::where('transaction_id', $transactionId)
            ->with(['product'])
            ->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function bulkStore(BulkStoreTransactionItemRequest $request)
    {
        $bulk = collect($request->all())->map(function ($arr, $key) {
            return Arr::only($arr, [
                "quantity",
                "price",
                "discount",
                "tax",
                "transaction_id",
                "product_id"
            ]);
        });

        TransactionItem::insert($bulk->toArray());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionItemRequest $request)
    {
        return new TransactionItemResource(TransactionItem::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionItem $transactionItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionItem $transactionItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionItemRequest $request, TransactionItem $transactionItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionItem $transactionItem)
    {
        //
    }
}
