<?php

namespace App\Http\Services\V1;

use Illuminate\Http\Request;


class DebtQuery
{
    protected $safeParams = [
        'type' => ['eq'],
        'isPaid' => ['eq'],
    ];

    protected $columnMap = [
        'isPaid' => 'is_paid',
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
                // Check if the query parameter exists and is not empty
                if (isset($query) && !empty($query)) {
                    // Adjust the condition based on the operator
                    switch ($operator) {
                        case 'eq':
                            $eloQuery[] = [$column, '=', $query];
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        return $eloQuery;
    }
}
