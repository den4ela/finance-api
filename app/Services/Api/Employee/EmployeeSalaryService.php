<?php

namespace App\Services\Api\Employee;

use \Illuminate\Http\JsonResponse;
use App\Traits\Api\EmployeeSalaryTrait;

/**
 * Class EmployeeSalaryService
 * @package App\Services\Api\Employee
 */
class EmployeeSalaryService
{
    use EmployeeSalaryTrait;

    /**
     * @param int $employee_id
     * @return JsonResponse
     */
    public function getSalary(int $employee_id) : JsonResponse
    {
        $response = [
            'status' => 'error'
        ];

        $employee_salary = $this->getEmployeeSalary($employee_id);

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
