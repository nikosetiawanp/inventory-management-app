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
use App\Models\Debt;
use App\Models\Account;


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
        $debt = Debt::find($request->debtId);
        $type = $debt->type;

        $debtAccount = Account::find(1);
        $receivableAccount = Account::find(2);

        // Create accounts only if they do not exist
        if (!$debtAccount) {
            $debtAccount = Account::create([
                'id' => "1",
                'number' => '21.10.10',
                'name' => 'Hutang Dagang',
            ]);
            $debtAccount->save();
        }

        if (!$receivableAccount) {
            $receivableAccount = Account::create([
                'id' => "2",
                'number' => '11.21.20',
                'name' => 'Piutang Dagang',
            ]);
            $receivableAccount->save();
        }

        // Prepare data for Payment and Cash
        $data = [
            'date' => $request->date,
            'amount' => $request->amount,
            'number' => $request->number,
            'cash_number' => $request->number,
            'debt_id' => $request->debtId,
            'account_id' => $type == 'D' ? 1 : 2,
            'contact_id' => $request->contactId,
            'description' => $request->description,
        ];

        // Create Payment
        Payment::create($data);

        // Create Cash (make sure Cash model has auto-incrementing id)
        Cash::create($data);
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
