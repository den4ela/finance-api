<?php

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Employee\EmployeeController;
use App\Http\Controllers\Api\Company\{ExpenseController, ProfitController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/', function () {
    dd(Order::select('employee_id')
        ->where('updated_at', '>=', Carbon::now()->subMonths(3))
        ->havingRaw('COUNT(DISTINCT(client_id)) as >= 30')
        ->get());
});
Route::get('/{id}', 'MetaController@index')->name('index');

Route::group([
    'prefix' => 'employee',
    'namespace' => 'Employee',
], function () {
    Route::group([
        'prefix' => 'salary',
    ], function () {
        Route::get('/{employee_id}', [EmployeeController::class, 'getEmployeeSalary']);
    });
});

Route::group([
    'prefix' => 'company',
    'namespace' => 'Company',
], function () {
    Route::group([
        'prefix' => 'expense',
    ], function () {
        Route::get('/', [ExpenseController::class, 'getExpenseByPeriod']);
    });
    Route::group([
        'prefix' => 'profit',
    ], function () {
        Route::get('/income', [ProfitController::class, 'getIncome']);
        Route::get('/profit', [ProfitController::class, 'getProfit']);
    });
});
