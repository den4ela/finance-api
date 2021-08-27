<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Models\{Order, User};
use App\Services\Api\Employee\EmployeeSalaryService;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    protected $employeeSalaryService;

    public function __construct(EmployeeSalaryService $employeeSalaryService)
    {
        $this->employeeSalaryService = $employeeSalaryService;
    }

    public function getEmployeeSalary($employee_id) {
        return response()->json($this->employeeSalaryService->getSalary($employee_id));
    }
}
