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
        // NEW
        // $startDate = Carbon::createFromFormat('d-m-Y', $request->input("startDate"))->startOfDay();
        // $endDate = Carbon::createFromFormat('d-m-Y', $request->input("endDate"))->startOfDay();
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");
        $status = $request->input("status");

        // $startDate = Carbon::createFromFormat('d-m-Y', $request->input('startDate'))->format('d-m-Y');
        // $endDate = Carbon::createFromFormat('d-m-Y', $request->input('endDate'))->format('d-m-Y');

        return new PurchaseCollection(Purchase::whereBetween('pr_date', [$startDate, $endDate])->where('status', $status)->with(['items.product', 'vendor'])->paginate());
        // $purchases = Purchase::whereBetween('pr_date', [$startDate, $endDate])->with(['items.product', 'vendor'])->paginate();
        // return $purchases;

        // OLD
        // $filter = new PurchaseQuery();
        // $queryItems = $filter->transform($request);
        // return new PurchaseCollection(Purchase::where($queryItems)->with(['items.product', 'vendor'])->paginate());

        // if (count($queryItems) == 0) {
        //     return [];
        // } else return new PurchaseCollection(Purchase::where($queryItems)->with(['items.product', 'vendor'])->paginate());
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
