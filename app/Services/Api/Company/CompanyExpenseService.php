<?php

namespace App\Services\Api\Company;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class CompanyExpenseService
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getExpenseByPeriod(Request $request) : JsonResponse
    {
        $response = [
            'status' => 'error'
        ];

        if ($request->has('from') && $request->has('to')) {
            $expense = Expense::selectRaw('SUM(amount) as expense')
                ->where('updated_at', '>=', Carbon::createFromDate($request->input('from'))->toDateTimeString())
                ->where('updated_at', '<=', Carbon::createFromDate($request->input('to'))->toDateTimeString())
                ->first();

            if ($expense)
                $response['body']['expense'] = $expense->expense;
        }
        else {
            $response['body']['message'] = 'Один из параметров из обязательных параметров ({from}, {to}) не был указан в запросе';
            return response()->json($response, 422);
        }

        return response()->json($response, 200);
    }
}
