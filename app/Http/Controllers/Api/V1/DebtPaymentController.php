<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDebtPaymentRequest;
use App\Http\Requests\V1\UpdateDebtPaymentRequest;
use App\Http\Resources\V1\DebtCollection;
use App\Http\Resources\V1\DebtPaymentCollection;
use App\Http\Resources\V1\DebtPaymentResource;
use App\Models\DebtPayment;
use Illuminate\Http\Request;

class DebtPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");

        $debtPayments = DebtPayment::whereBetween("paid_date", [$startDate, $endDate])
            ->with(['debt.invoice'])
            ->get();

        return new DebtPaymentCollection($debtPayments);
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
    public function store(StoreDebtPaymentRequest $request)
    {
        return $request->date;
        // return new DebtPaymentResource(DebtPayment::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(DebtPayment $debtPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DebtPayment $debtPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDebtPaymentRequest $request, DebtPayment $debtPayment)
    {
        $debtPayment->update($request->all());
        return new DebtPaymentResource($debtPayment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DebtPayment $debtPayment)
    {
        if ($debtPayment) {
            $debtPayment->delete();
        }
    }
}
