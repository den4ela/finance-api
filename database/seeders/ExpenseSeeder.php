<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Expense, Order, User};
use \Carbon\Carbon;

class ExpenseSeeder extends Seeder
{
    /**
     * Данный сидер эмулирует CRON задачу рассчета ЗП за текущий месяц.
     * ВАЖНО! Это всего ли демонстрация работы как CRON задачи.
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
                'employee_id' => $best_month_employee->id,
                'amount' => 200,
                'details' => [
                    'type' => 'best_month_employee',
                    'description' => 'Лучший сотрудник'
                ]
            ]);
        }

        // Сотрудники с клиентской базой превышающей 30 постоянных клиентов
        // Этот блок необходимо вынести в отдельную CRON задачу, которая бы запускалась каждый квартал.
//        $quarterly_bonus_users = Order::selectRaw('employee_id, COUNT(client_id) as count_clients')
//            ->where('updated_at', '>=', Carbon::now()->subMonths(3))
//            ->groupBy('employee_id')
//            ->orderBy('sum', 'DESC')
//            ->first();

    }
}
