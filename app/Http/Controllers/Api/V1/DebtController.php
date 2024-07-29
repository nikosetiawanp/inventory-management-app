<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreDebtRequest;
use App\Http\Requests\V1\UpdateDebtRequest;
use App\Http\Resources\V1\DebtCollection;
use App\Http\Resources\V1\DebtResource;
use App\Http\Services\V1\DebtQuery;
use App\Models\Debt;
use App\Models\Contact;
use Illuminate\Http\Request;
use Carbon\Carbon;


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
        $yearMonth = $request->input("yearMonth");

        if ($yearMonth) {
            $yearMonth = request()->query('yearMonth'); // '2024-07'
            $startOfMonth = Carbon::parse($yearMonth . '-01')->startOfMonth();
            $endOfMonth = Carbon::parse($yearMonth . '-01')->endOfMonth();
            $endOfPreviousMonth = Carbon::parse($yearMonth . '-01')->subMonth()->endOfMonth();

            $initialBalances = Contact::leftJoin('debts', 'contacts.id', '=', 'debts.contact_id')
                ->leftJoin('invoices', 'debts.invoice_id', '=', 'invoices.id')
                ->leftJoin('payments', function ($join) use ($endOfPreviousMonth) {
                    $join->on('debts.id', '=', 'payments.debt_id')
                        ->where('payments.date', '<=', $endOfPreviousMonth);
                })
                ->where(function ($query) use ($endOfPreviousMonth) {
                    $query->where('invoices.date', '<=', $endOfPreviousMonth)
                        ->orWhereNull('invoices.date');
                })
                ->groupBy('contacts.id')
                ->selectRaw(
                    'contacts.id as contactId,
         contacts.name as name,
         COALESCE(SUM(debts.amount), 0) as totalDebtUpToLastMonth,
         COALESCE(SUM(payments.amount), 0) as totalPaymentUpToLastMonth'
                )
                ->get()
                ->keyBy('contactId');

            $results = Contact::leftJoin('debts', 'contacts.id', '=', 'debts.contact_id')
                ->leftJoin('invoices', 'debts.invoice_id', '=', 'invoices.id')
                ->leftJoin('payments', function ($join) use ($startOfMonth, $endOfMonth) {
                    $join->on('debts.id', '=', 'payments.debt_id')
                        ->whereBetween('payments.date', [$startOfMonth, $endOfMonth]);
                })
                ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                    $query->whereBetween('invoices.date', [$startOfMonth, $endOfMonth])
                        ->orWhereNull('invoices.date');
                })
                ->groupBy('contacts.id')
                ->selectRaw(
                    'contacts.id as contactId,
         contacts.name as name,
         COALESCE(SUM(debts.amount), 0) as totalDebtThisMonth,
         COALESCE(SUM(payments.amount), 0) as totalPaymentThisMonth'
                )
                ->get()
                ->map(function ($item) use ($initialBalances) {
                    $initialBalance = 0;

                    if (isset($initialBalances[$item->contactId])) {
                        $initialBalance = $initialBalances[$item->contactId]->totalDebtUpToLastMonth
                            - $initialBalances[$item->contactId]->totalPaymentUpToLastMonth;
                    }

                    $item->initialBalance = $initialBalance;
                    $item->currentBalance = $initialBalance
                        + $item->totalDebtThisMonth
                        - $item->totalPaymentThisMonth;

                    return [
                        'contactId' => $item->contactId,
                        'name' => $item->name,
                        'id' => $item->contactId,
                        'initialBalance' => $item->initialBalance,
                        'totalPayment' => $item->totalPaymentThisMonth,
                        'totalDebt' => $item->totalDebtThisMonth,
                        'currentBalance' => $item->currentBalance,
                    ];
                });

            return $results;
            // $yearMonth = request()->query('yearMonth');
            // $upToDateEndOfMonth = Carbon::parse($yearMonth . '-01')->endOfMonth()->toDateString(); //convert 2024-07 to 2024-07-31
            // $results = Debt::join('invoices', 'debts.invoice_id', '=', 'invoices.id')
            //     ->join('contacts', 'debts.contact_id', '=', 'contacts.id')
            //     ->leftJoin('payments', function ($join) use ($upToDateEndOfMonth) {
            //         $join->on('debts.id', '=', 'payments.debt_id')
            //             ->where('payments.date', '<=', $upToDateEndOfMonth);
            //     })
            //     ->where('invoices.date', '<=', $upToDateEndOfMonth)
            //     ->groupBy('debts.contact_id', 'contacts.id')
            //     ->selectRaw(
            //         'debts.contact_id as contactId,
            //          contacts.name as name,
            //          contacts.id,
            //          SUM(debts.amount) as totalDebt,
            //          SUM(payments.amount) as totalPayment'
            //     )
            //     // ->with(['payments' => function ($query) use ($upToDateEndOfMonth) {
            //     //     $query->where('date', '<=', $upToDateEndOfMonth);
            //     // }])
            //     ->get();

            // return $results;
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
