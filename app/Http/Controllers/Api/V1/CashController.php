<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCashRequest;
use App\Http\Requests\V1\UpdateCashRequest;
use App\Http\Resources\V1\CashCollection;
use App\Http\Resources\V1\CashResource;
use App\Models\Cash;
use Illuminate\Http\Request;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->input("startDate");
        $endDate = $request->input("endDate");

        return new CashCollection(Cash::whereBetween('date', [$startDate, $endDate])
            ->with(['account'])
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
    public function store(StoreCashRequest $request)
    {
        // return new CashResource(Cash::create([
        //     'date' => $request->date,
        //     'number' => $request->number,
        //     'amount' => $request->amount,
        //     'description' => $request->description,
        //     'account_id' => $request->accountId
        // ]));
        return new CashResource(Cash::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cash $cash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cash $cash)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCashRequest $request, Cash $cash)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cash $cash)
    {
        if ($cash) {
            $cash->delete();
        }
    }
}
