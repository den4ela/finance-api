<?php

namespace App\Services\Api\Company;

use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use App\Traits\Api\ProfitTrait;

class IncomeService
{
    use ProfitTrait;

    public function getIncomeAmount(Request $request) : JsonResponse
    {
        $response = [
            'status' => 'error'
        ];

        if ($request->has('from') && $request->has('to')) {
            $income = $this->getIncomeFromOrderByDateRange($request->input('from'), $request->input('to'));

            $response = [
                'status' => 'ok',
                'body' => [
                    'income' => number_format($income, 2)
                ]
            ];
        }
        else {
            $response['body']['message'] = 'Один из параметров из обязательных параметров ({from}, {to}) не был указан в запросе';
            return response()->json($response, 422);
        }

        return response()->json($response, 200);
    }
}
