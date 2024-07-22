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
    // public function index(Request $request)
    // {
    //     $startDate = $request->input("startDate");
    //     $endDate = $request->input("endDate");
    //     $isApproved = $request->input("isApproved");
    //     $isDone = $request->input("isDone");
    //     $type = $request->input("type");

    //     if ($isApproved) {
    //         return new TransactionCollection(Transaction::whereBetween('date', [$startDate, $endDate])
    //             ->where('is_approved', $isApproved)
    //             ->with(['contact', 'inventories'])
    //             ->get());
    //     } else if ($isDone) {
    //     return new TransactionCollection(Transaction::whereBetween('date', [$startDate, $endDate])
    //         ->where('is_approved', $isApproved)
    //         ->where('is_done', $isDone)
    //         ->with(['contact', 'inventories'])
    //         ->paginate());
    //     } else {
    //         return new TransactionCollection(Transaction::whereBetween('date', [$startDate, $endDate])
    //             ->with(['contact'])
    //             ->paginate());
    //     }
    // }

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
                    ->with(['contact', 'inventories'])
                    ->orderBy('date', 'asc')
                    ->paginate()
            );
        } else {
            return new TransactionCollection(
                Transaction::where($queryItems)
                    ->with(['contact', 'inventories'])
                    ->orderBy('date', 'asc')
                    ->paginate()
            );
        }
        // if (count($queryItems) == 0) {
        //     return new TransactionCollection(Transaction::whereBetween('date', [$startDate, $endDate])
        //         ->with(['contact', 'inventories'])
        //         ->paginate());
        // } else {
        //     return new TransactionCollection(Transaction::whereBetween('date', [$startDate, $endDate])
        //         ->with(['contact', 'inventories'])
        //         ->where($queryItems)
        //         ->paginate());
        // }
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
