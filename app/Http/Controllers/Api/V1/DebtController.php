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
use App\Http\Resources\V1\ContactCollection;

use Carbon\Carbon;


class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function getDebtHistory(Request $request)
    {
        $type = $request->input("type");
        $startDate = $request->input("startDate"); // Expecting 'YYYY-MM-DD'
        $endDate = $request->input("endDate"); // Expecting 'YYYY-MM-DD'
        $contactIds = $request->input("contactId"); // Expecting an array of contact IDs

        $contactsQuery = Contact::where('type', $type);

        if ($contactIds) {
            $contactsQuery->whereIn('id', $contactIds); // Use whereIn for multiple IDs
        }

        if (!$startDate || !$endDate) {
            return [];
        }

        $contacts = $contactsQuery->get();

        $monthlyReport = $contacts->map(function ($contact) use ($startDate, $endDate) {
            // Filter debts and payments for the specified date range
            $debtsThisMonth = $contact->debts->filter(function ($debt) use ($startDate, $endDate) {
                return $debt->invoice->date <= $endDate && $debt->invoice->date >= $startDate;
            })->map(function ($debt) {
                return [
                    'id' => $debt->id,
                    'amount' => $debt->amount,
                    'createdAt' => $debt->created_at,
                    'type' => $debt->type,
                    'date' => $debt->invoice->date,
                    'invoiceNumber' => $debt->invoice->number
                ];
            });

            $paymentsThisMonth = $contact->payments->filter(function ($payment) use ($startDate, $endDate) {
                return $payment->date <= $endDate && $payment->date >= $startDate;
            })->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'amount' => $payment->amount,
                    'createdAt' => $payment->created_at,
                    'type' => 'P',
                    'date' => $payment->date,
                    'description' => $payment,
                    'invoiceNumber' => $payment->debt->invoice->number
                ];
            });

            // Combine debts and payments into one array
            $transactionsThisMonth = $debtsThisMonth->merge($paymentsThisMonth)->sortBy('date')->values()->toArray();

            // Filter debts and payments up to the start date
            $debtsUpToLastMonth = $contact->debts->filter(function ($debt) use ($startDate) {
                return $debt->invoice->date < $startDate;
            });
            $paymentsUpToLastMonth = $contact->payments->filter(function ($payment) use ($startDate) {
                return $payment->date < $startDate;
            });

            // Calculate totals
            $initialBalance = $debtsUpToLastMonth->sum('amount') - $paymentsUpToLastMonth->sum('amount');
            $totalDebts = $debtsThisMonth->sum('amount');
            $totalPayments = $paymentsThisMonth->sum('amount');
            $currentBalance = $initialBalance + ($totalDebts - $totalPayments);

            // Return the formatted contact data
            return [
                'id' => $contact->id,
                'name' => $contact->name,
                'code' => $contact->code,
                'initialBalance' => $initialBalance,
                'totalDebt' => $totalDebts,
                'totalPayment' => $totalPayments,
                'currentBalance' => $currentBalance,
                'histories' => $transactionsThisMonth,
            ];
        });

        return $monthlyReport;
    }


    public function index(Request $request)
    {
        $filter = new DebtQuery();
        $queryItems = $filter->transform($request);
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");
        $type = $request->input("type");

        $query = Debt::query();

        if ($startDate || $endDate) {
            $query->whereHas('invoice', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            });
        }

        if ($type) {
            $query->where('type', $type);
        }

        $query->where($queryItems)
            ->with(['contact', 'payments', 'invoice']);

        return new DebtCollection($query->paginate());
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
