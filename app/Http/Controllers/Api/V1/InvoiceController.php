<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreInvoiceRequest;
use App\Http\Requests\V1\UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $startDate = $request->input("startDate");
    //     $endDate = $request->input("endDate");

    //     return new InvoiceCollection(
    //         Invoice::whereBetween('date', [$startDate, $endDate])
    //             ->with(['transaction.contact', 'inventory', 'debts'])
    //             ->get()
    //     );
    // }

    public function index(Request $request)
    {
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");
        $type = $request->input("type"); // Get the transaction type from the request

        return new InvoiceCollection(
            Invoice::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })
                ->when($type, function ($query) use ($type) {
                    $query->whereHas('transaction', function ($query) use ($type) {
                        $query->where('type', $type);
                    });
                })
                ->with(['transaction.contact', 'inventory', 'debts'])
                ->get()
        );
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
    public function store(StoreInvoiceRequest $request)
    {
        return new InvoiceResource(Invoice::create($request->all()));
        // return new InventoryResource(Inventory::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice) {
            $invoice->delete();
        }
    }
}
