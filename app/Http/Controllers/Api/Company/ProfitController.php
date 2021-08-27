<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Services\Api\Company\{IncomeService, ProfitService};
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    /**
     * @var IncomeService
     */
    protected $incomeService;

    /**
     * @var ProfitService
     */
    protected $profitService;

    /**
     * ProfitController constructor.
     * @param IncomeService $incomeService
     * @param ProfitService $profitService
     */
    public function __construct(IncomeService $incomeService, ProfitService $profitService)
    {
        $this->incomeService = $incomeService;
        $this->profitService = $profitService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getIncome(Request $request)
    {
        return $this->incomeService->getIncomeAmount($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getProfit(Request $request)
    {
        return $this->profitService->getProfitAmount($request);
    }
}
