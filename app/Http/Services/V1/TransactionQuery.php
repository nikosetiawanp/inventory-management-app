<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class TransactionQuery
{
    protected $safeParams = [
        'type' => ['eq'],
        'isApproved' => ['eq'],
        'isDone' => ['eq'],
    ];

    protected $columnMap = [
        'isApproved' => 'is_approved',
        'isDone' => 'is_done'
    ];

    protected $operatorMap = [
        'eq' => '='
    ];

    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParams as $param => $operators) {
            $query = $request->query($param);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operator) {
                if (!isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }
        return $eloQuery;
    }
}
