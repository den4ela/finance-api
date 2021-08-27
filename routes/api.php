<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Employee\EmployeeController;

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
