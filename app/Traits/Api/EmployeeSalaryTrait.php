<?php

namespace App\Traits\Api;

use App\Models\Expense;
use Carbon\Carbon;

/**
 * Trait EmployeeSalaryTrait
 * @package App\Traits\Api
 */
trait EmployeeSalaryTrait
{
    /**
     * @param $employee_id
     * @return Expense
     *
     * Рассчет ЗП сотрудника за текущий месяц
     */
    protected function getEmployeeSalary($employee_id) : Expense
    {
        return Expense::selectRaw('employee_id, SUM(amount) as salary')
            ->where('updated_at', '>=', Carbon::now()->startOfMonth())
            ->where('employee_id', $employee_id)
            ->first();
    }
}
