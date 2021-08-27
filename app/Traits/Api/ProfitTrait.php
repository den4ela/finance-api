<?php

namespace App\Traits\Api;

use App\Models\{Order, Expense};
use Carbon\Carbon;

trait ProfitTrait
{
    protected function getIncomeFromOrderByDateRange($from, $to)
    {
        return Order::where('updated_at', '>=', Carbon::createFromDate($from)->toDateTimeString())
            ->where('updated_at', '<=', Carbon::createFromDate($to)->toDateTimeString())
            ->sum('amount');
    }

    protected function getExpenseByPeriod($from, $to)
    {
        $expense = Expense::selectRaw('SUM(amount) as expense')
            ->where('updated_at', '>=', Carbon::createFromDate($from)->toDateTimeString())
            ->where('updated_at', '<=', Carbon::createFromDate($to)->toDateTimeString())
            ->first();

        return ($expense) ? $expense->expense : false;
    }
}
