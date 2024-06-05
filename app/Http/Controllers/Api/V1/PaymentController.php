<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StorePaymentRequest;
use App\Http\Requests\V1\UpdatePaymentRequest;
use App\Http\Resources\V1\PaymentCollection;
use App\Http\Resources\V1\PaymentResource;
use App\Models\Payment;
use App\Models\Cash;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");

        return new PaymentCollection(Payment::with(['debt.invoice'])
            ->get());
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
    public function store(StorePaymentRequest $request)
    {
        return new PaymentResource(Payment::create($request->all()));
        // try {
        //     $payment = Payment::create($request->all());
        //     Cash::create([
        //         'date' => $request->date,
        //         'number' => $request->number,
        //         'amount' => $request->amount,
        //         'description' => $request->description,
        //         'account_id' => $request->accountId
        //     ]);
        //     return new PaymentResource($payment);
        // } catch (\Exception $e) {
        //     logger()->error('Error creating cash record: ' . $e->getMessage());
        //     return response()->json(['message' => 'ERROR'], 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if ($payment) {
            $payment->delete();
        }
    }
}
