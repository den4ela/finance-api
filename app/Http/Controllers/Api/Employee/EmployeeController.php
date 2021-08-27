<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Services\Api\Employee\EmployeeSalaryService;

class EmployeeController extends Controller
{
    protected $employeeSalaryService;

    public function __construct(EmployeeSalaryService $employeeSalaryService)
    {
        $this->employeeSalaryService = $employeeSalaryService;
    }

    public function getEmployeeSalary($employee_id) {
        return $this->employeeSalaryService->getSalary($employee_id);
    }
}
