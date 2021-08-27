<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Services\Api\Company\CompanyExpenseService;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    protected $companyExpenseService;

    public function __construct(CompanyExpenseService $companyExpenseService)
    {
        $this->companyExpenseService = $companyExpenseService;
    }

    public function getExpenseByPeriod(Request $request)
    {
        return $this->companyExpenseService->getExpenseByPeriod($request);
    }
}
