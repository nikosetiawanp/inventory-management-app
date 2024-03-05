<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\UpdatePurchaseRequest;
use App\Http\Requests\V1\StorePurchaseRequest;
use App\Http\Resources\V1\PurchaseCollection;
use App\Http\Resources\V1\PurchaseResource;
use App\Models\Purchase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");
        $isApproved = $request->input("isApproved");
        $isDone = $request->input("isDone");

        // return new PurchaseCollection(Purchase::whereBetween('date', [$startDate, $endDate])
        // ->where('is_approved', $isApproved)
        // ->where('is_done', $isDone)
        // ->with(['contact'])
        // ->get());

        if ($isApproved) {
            return new PurchaseCollection(Purchase::whereBetween('date', [$startDate, $endDate])
                ->where('is_approved', $isApproved)
                ->with(['contact', 'inventories'])
                ->get());
        } else if ($isDone) {
            return new PurchaseCollection(Purchase::whereBetween('date', [$startDate, $endDate])
                ->where('is_approved', $isApproved)
                ->where('is_done', $isDone)
                ->with(['contact', 'inventories'])
                ->get());
        } else {
            return new PurchaseCollection(Purchase::whereBetween('date', [$startDate, $endDate])
                ->with(['contact'])
                ->paginate());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        return new PurchaseResource(Purchase::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load('items.product');
        return new PurchaseResource($purchase);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        $purchase->update($request->all());
        return new PurchaseResource($purchase);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        if ($purchase) {
            $purchase->delete();
        }
    }
}
