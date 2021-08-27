<?php

namespace App\Services\Api\Company;

use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use App\Traits\Api\ProfitTrait;

class ProfitService
{
    use ProfitTrait;

    public function getProfitAmount(Request $request) : JsonResponse
    {
        $response = [
            'status' => 'error'
        ];

        if ($request->has('from') && $request->has('to')) {
            $income = $this->getIncomeFromOrderByDateRange($request->input('from'), $request->input('to'));
            $expense = $this->getExpenseByPeriod($request->input('from'), $request->input('to'));

            if ($expense !== false) {
                $response = [
                    'status' => 'ok',
                    'body' => [
                        'profit' => number_format($income - $expense, 2)
                    ]
                ];
            }
            else {
                $response['body']['message'] = 'Ошибка получения данных';
                return response()->json($response, 422);
            }
        }
        else {
            $response['body']['message'] = 'Один из параметров из обязательных параметров ({from}, {to}) не был указан в запросе';
            return response()->json($response, 422);
        }

        return response()->json($response, 200);
    }
}
