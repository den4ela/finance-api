<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Services\Api\Employee\EmployeeSalaryService;
use \Illuminate\Http\JsonResponse;

/**
 * Class EmployeeController
 * @package App\Http\Controllers\Api\Employee
 */
class EmployeeController extends Controller
{
    /**
     * @var EmployeeSalaryService
     */
    protected $employeeSalaryService;

    /**
     * EmployeeController constructor.
     * @param EmployeeSalaryService $employeeSalaryService
     */
    public function __construct(EmployeeSalaryService $employeeSalaryService)
    {
        $this->employeeSalaryService = $employeeSalaryService;
    }


    /**
     * @param $employee_id
     * @return JsonResponse
     */
    public function getEmployeeSalary($employee_id) : JsonResponse
    {
        return $this->employeeSalaryService->getSalary($employee_id);
    }
}
