<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Expense, Order, User};
use \Carbon\Carbon;

class ExpenseSeeder extends Seeder
{
    /**
     * Данный сидер эмулирует CRON задачу рассчета ЗП за текущий месяц.
     * ВАЖНО! Это всего ли демонстрация работы как CRON задачи, которая должна запускатся в конце каждого месяца.
     */

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Выдача фиксированной ЗП
        $employees = User::role('employee')->get();
        if ($employees->count() > 0) {
            foreach ($employees as $employee) {
                Expense::create([
                    'employee_id' => $employee->id,
                    'amount' => 500,
                    'details' => [
                        'type' => 'salary',
                        'description' => 'Месячная заработная плата'
                    ]
                ]);
            }
        }

        // Награждение лучшего сотрудника
        $best_month_employee = Order::selectRaw('employee_id, SUM(amount) as sum')
            ->where('updated_at', '>=', Carbon::now()->startOfMonth())
            ->groupBy('employee_id')
            ->orderBy('sum', 'DESC')
            ->first();

        if ($best_month_employee) {
            Expense::create([
                'employee_id' => $best_month_employee->employee_id,
                'amount' => 200,
                'details' => [
                    'type' => 'best_month_employee',
                    'description' => 'Лучший сотрудник'
                ]
            ]);
        }

        // Сотрудники с клиентской базой превышающей 30 постоянных клиентов
        // Этот блок необходимо вынести в отдельную CRON задачу, которая бы запускалась каждый квартал.

//        $employee_ids = Order::select('employee_id')
//            ->where('updated_at', '>=', Carbon::now()->subMonths(3))
//            ->havingRaw('COUNT(DISTINCT(client_id)) as >= 30')
//            ->get();
//
//        if ($employee_ids->count() > 0) {
//            foreach ($employee_ids as $employee_id) {
//                $client_ids = Order::selectRaw('DISTINCT(client_id) as client_id')
//                    ->where('updated_at', '>=', Carbon::now()->subMonths(3))
//                    ->where('employee_id', $employee_id->employee_id)
//                    ->get();
//
//                if ($client_ids->count() > 0) {
//                    $i = 0;
//                    foreach ($client_ids as $client_id) {
//                        $count = Order::where('employee_id', $employee_id->employee_id)
//                            ->where('client_id', $client_id->client_id)
//                            ->count();
//                        if ($count > 0)
//                            $i++;
//                    }
//                    if (!$i >= 30) {
//                        $employee_ids->forget($employee_id->employee_id);
//                    }
//                }
//            }
//        }
    }
}
