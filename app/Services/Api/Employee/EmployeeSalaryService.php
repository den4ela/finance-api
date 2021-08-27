<?php

namespace App\Services\Api\Employee;

use App\Models\Expense;
use Carbon\Carbon;
use \Illuminate\Http\JsonResponse;

class EmployeeSalaryService
{
    public function getSalary(int $employee_id) : JsonResponse
    {
        $response = [
            'status' => 'error'
        ];

        $employee_salary = Expense::selectRaw('employee_id, SUM(amount) as salary')
            ->where('updated_at', '>=', Carbon::now()->startOfMonth())
            ->where('employee_id', $employee_id)
            ->first();

        if ($employee_salary) {
            $response = [
                'status' => 'ok',
                'body' => [
                    'employee_salary' => number_format($employee_salary->salary, 2)
                ]
            ];
        }

        return response()->json($response);
    }
}
