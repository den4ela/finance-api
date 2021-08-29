<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Expense};
use \Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * @var
     */
    private $random_timestamps;

    /**
     * OrderSeeder constructor.
     */
    public function __construct()
    {
        for ($days = 1; $days < 15; $days += 5) {
            $this->random_timestamps[] = Carbon::now()->addDays($days)->toDateTimeString();
        }
    }

    /**
     * @param int $client_id
     * @param int $employee_id
     */
    private function createRandomOrder(int $client_id, int $employee_id)
    {
        for ($i = 0; $i < mt_rand(1, 5); $i++) {
            $timestamp = $this->random_timestamps[array_rand($this->random_timestamps, 1)];
            $amount = mt_rand(1, 1000) / 10;

            $insert_id = \DB::table('orders')->insertGetId([
                'client_id' => $client_id,
                'employee_id' => $employee_id,
                'amount' => $amount,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);

            if ($insert_id) {
                Expense::create([
                    'employee_id' => $employee_id,
                    'amount' => $amount * 0.03,
                    'details' => [
                        'type' => 'percentage_of_sale',
                        'description' => 'Процент от заказа №'.$insert_id
                    ]
                ]);
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = User::role('employee')
            ->limit(5)
            ->get();

        $first_31_clients = User::role('client')
            ->skip(0)
            ->take(31)
            ->get();

        $other_clients = User::role('client')
            ->skip(31)
            ->take(100)
            ->get();


        foreach ($first_31_clients as $client) {
            $this->createRandomOrder($client->id, $employees->first()->id);
        }

        foreach ($other_clients as $client) {
            $this->createRandomOrder($client->id, $employees->random()->id);
        }
    }
}
