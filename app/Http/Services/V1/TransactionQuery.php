<?php

namespace App\Http\Services\V1;

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


    // public function transform(Request $request)
    // {
    //     $eloQuery = [];

    //     foreach ($this->safeParams as $param => $operators) {
    //         $query = $request->query($param);

    //         if (!isset($query)) {
    //             continue;
    //         }

    //         $column = $this->columnMap[$param] ?? $param;

    //         foreach ($operators as $operator) {
    //             if (!isset($query[$operator])) {
    //                 $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
    //             }
    //         }
    //     }
    //     return $eloQuery;
    // }

    //     public function transform(Request $request)
// {
//     $eloQuery = [];

    //     foreach ($this->safeParams as $param => $operators) {
//         $query = $request->query($param);

    //         if (!isset($query)) {
//             continue;
//         }

    //         $column = $this->columnMap[$param] ?? $param;

    //         foreach ($operators as $operator) {
//             if (isset($query[$operator])) { // Corrected condition
//                 $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]]; // Include query value
//             }
//         }
//     }

    //     return $eloQuery;
// }

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
                            // For 'eq' operator, directly add the condition
                            $eloQuery[] = [$column, '=', $query];
                            break;
                        // Add other cases for different operators if needed
                        // case 'gt':
                        //     $eloQuery[] = [$column, '>', $query];
                        //     break;
                        // case 'lt':
                        //     $eloQuery[] = [$column, '<', $query];
                        //     break;
                        default:
                            // Handle unsupported operators or do nothing
                            break;
                    }
                }
            }
        }

        return $eloQuery;
    }


}
