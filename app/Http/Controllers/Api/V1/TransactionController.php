<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreTransactionRequest;
use App\Http\Requests\V1\UpdateTransactionRequest;
use App\Http\Resources\V1\TransactionCollection;
use App\Http\Resources\V1\TransactionResource;
use App\Http\Services\V1\TransactionQuery;
use App\Models\Transaction;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $filter = new TransactionQuery();
        $queryItems = $filter->transform($request);
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");

        if ($startDate or $endDate) {
            return new TransactionCollection(
                Transaction::whereBetween('date', [$startDate, $endDate])
                    ->where($queryItems)
                    ->with(['contact', 'transactionItems.product', 'inventories.inventoryItems', 'invoices.transaction'])
                    ->orderBy('date', 'desc')
                    ->get()
            );
        } else {
            return new TransactionCollection(
                Transaction::where($queryItems)
                    ->with(['contact', 'transactionItems.product', 'inventories.inventoryItems', 'invoices.transaction'])
                    ->orderBy('date', 'desc')
                    ->get()
            );
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
    public function store(StoreTransactionRequest $request)
    {
        return new TransactionResource(Transaction::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('items.product');
        return new TransactionResource($transaction);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->all());
        return new TransactionResource($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction) {
            $transaction->delete();
        }
    }
}
