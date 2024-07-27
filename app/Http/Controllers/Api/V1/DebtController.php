<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDebtRequest;
use App\Http\Requests\V1\UpdateDebtRequest;
use App\Http\Resources\V1\DebtCollection;
use App\Http\Resources\V1\DebtResource;
use App\Http\Services\V1\DebtQuery;
use App\Models\Debt;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new DebtQuery();
        $queryItems = $filter->transform($request);
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");
        $upToDate = $request->input("upToDate");

        if ($upToDate) {
            $totalAmount = Debt::join('invoices', 'debts.invoice_id', '=', 'invoices.id')
                ->where('invoices.date', '<=', $upToDate)
                ->sum('debts.amount');

            // $results = Debt::join('invoices', 'debts.invoice_id', '=', 'invoices.id')
            //     ->where('invoices.date', '<=', $upToDate)
            //     ->groupBy('debts.contact_id')
            //     ->selectRaw('debts.contact_id, SUM(debts.amount) as total_amount')
            //     ->get();
            $results = Debt::join('invoices', 'debts.invoice_id', '=', 'invoices.id')
                ->join('contacts', 'debts.contact_id', '=', 'contacts.id')
                ->where('invoices.date', '<=', $upToDate)
                ->groupBy('debts.contact_id', 'contacts.name')
                ->selectRaw('debts.contact_id, contacts.name, SUM(debts.amount) as total_debt')
                ->get();

            return $results;

            // return Debt::sum('amount');
            // $debts = Debt::join('invoices', 'debts.invoice_id', '=', 'invoices.id')
            //     ->where('invoices.date', '<=', $upToDate)
            //     ->with(['contact', 'invoice'])
            //     ->select('debts.*')
            //     ->get();

            // return new DebtCollection($debts);
        }

        if ($startDate or $endDate) {
            return new DebtCollection(
                Debt::whereHas('invoice', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('date', [$startDate, $endDate]);
                })
                    ->with(['contact', 'payments', 'invoice'])
                    ->paginate()
            );
        } else {
            return new DebtCollection(
                Debt::where($queryItems)
                    ->with(['contact', 'payments', 'invoice'])
                    ->paginate()
            );
        }
    }

    public function getDebtsUpToDate()
    {
        return [];

        // return new DebtCollection(
        //     Debt::join('invoices', 'debts.invoice_id', '=', 'invoices.id')
        //         ->where('invoices.date', '<=', $date)
        //         ->select('debts.*')
        //         ->get()
        // );
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
    public function store(StoreDebtRequest $request)
    {
        return new DebtResource(Debt::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Debt $debt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debt $debt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDebtRequest $request, Debt $debt)
    {
        $debt->update($request->all());
        return new  DebtResource($debt);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debt $debt)
    {
        if ($debt) {
            $debt->delete();
        }
    }
}
