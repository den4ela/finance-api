<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
            \DB::table('orders')->insert([
                'client_id' => $client_id,
                'employee_id' => $employee_id,
                'amount' => mt_rand(1, 1000) / 10,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);
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


        $index = 0;
        foreach ($employees as $employee) {
            if ($index === 0) {
                foreach ($first_31_clients as $client) {
                    $this->createRandomOrder($client->id, $employee->id);
                }
            }
            else {
                foreach ($other_clients as $client) {
                    $this->createRandomOrder($client->id, $employee->id);
                }
            }
            $index++;
        }
    }
}