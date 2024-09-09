<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCashRequest;
use App\Http\Requests\V1\UpdateCashRequest;
use App\Http\Resources\V1\AccountResource;
use App\Http\Resources\V1\CashCollection;
use App\Http\Resources\V1\CashResource;
use App\Models\Cash;
use App\Models\Account;
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
        return new AccountResource(Account::create($request->all()));
        // $accountId = $request->accountId;
        // $account = Account::find($accountId);

        // var_dump($account);

        // if (!$account && $accountId == 1) {
        //     $account = Account::create([
        //         'id' => 1,
        //         'number' => '21.10.10',
        //         'name' => 'Hutang Dagang',
        //     ]);
        //     return new CashResource(Cash::create($request->all()));
        // } else if (!$account && $accountId == 2) {
        //     $account = Account::create([
        //         'id' => 2,
        //         'number' => '11.21.20',
        //         'name' => 'Piutang Dagang',
        //     ]);
        //     return new CashResource(Cash::create($request->all()));
        // } else {
        //     return new CashResource(Cash::create($request->all()));
        // }
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
