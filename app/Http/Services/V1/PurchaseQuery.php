<?php

namespace App\Http\Services\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class PurchaseQuery
{
    protected $safeParms = [
        'vendorId' => ['eq'],
        'prDate' => ['eq'],
        'prNumber' => ['eq'],
        'poDate' => ['eq'],
        'poNumber' => ['eq'],
    ];

    protected $columnMap = [
        'vendorId' => 'vendor_id',
        'prDate' => 'pr_date',
        'prNumber' => 'pr_number',
        'poDate' => 'po_date',
        'poNumber' => 'po_number',
    ];

    protected $operatorMap = [
        'eq' => '='
    ];

    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);
            if (!isset($query)) {
                continue;
            }
            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
            return $eloQuery;
        }
    }
}
