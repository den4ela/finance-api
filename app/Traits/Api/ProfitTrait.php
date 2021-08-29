<?php

namespace App\Traits\Api;

use App\Models\{Order, Expense};
use Carbon\Carbon;

/**
 * Trait ProfitTrait
 * @package App\Traits\Api
 */
trait ProfitTrait
{
    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    protected function getIncomeFromOrderByDateRange($from, $to)
    {
        return Order::where('updated_at', '>=', Carbon::createFromDate($from)->toDateTimeString())
            ->where('updated_at', '<=', Carbon::createFromDate($to)->toDateTimeString())
            ->sum('amount');
    }

    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    protected function getExpenseByPeriod($from, $to)
    {
        $expense = Expense::selectRaw('SUM(amount) as expense')
            ->whereBetween('updated_at', [
                Carbon::createFromDate($from)->toDateTimeString(),
                Carbon::createFromDate($to)->toDateTimeString()
            ])
            ->first();

        return ($expense) ? $expense->expense : false;
    }
}
