<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Services\Api\Company\CompanyExpenseService;
use Illuminate\Http\Request;

/**
 * Class ExpenseController
 * @package App\Http\Controllers\Api\Company
 */
class ExpenseController extends Controller
{
    /**
     * @var CompanyExpenseService
     */
    protected $companyExpenseService;

    /**
     * ExpenseController constructor.
     * @param CompanyExpenseService $companyExpenseService
     */
    public function __construct(CompanyExpenseService $companyExpenseService)
    {
        $this->companyExpenseService = $companyExpenseService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExpenseByPeriod(Request $request)
    {
        return $this->companyExpenseService->getExpenseByPeriod($request);
    }
}
