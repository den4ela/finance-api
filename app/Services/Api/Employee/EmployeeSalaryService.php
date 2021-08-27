<?php

namespace App\Services\Api\Employee;

use App\Models\Expense;
use Carbon\Carbon;

class EmployeeSalaryService
{
    public function getSalary(int $employee_id) : array
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

        return $response;
    }
}
