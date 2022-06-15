<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommissionCalculatorRequest;
use App\Import\TransactionImport;
use App\Services\TransactionService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CommissionCalculatorController
{
    private TransactionImport $transactionImport;
    private TransactionService $transactionService;

    /**
     * CommissionCalculatorController constructor.
     * @param TransactionImport $transactionImport
     * @param TransactionService $transactionService
     */
    public function __construct(TransactionImport $transactionImport, TransactionService $transactionService)
    {
        $this->transactionImport = $transactionImport;
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(): Factory|View|Application
    {
        $transactions = [];
        return view('commission-calculator.index', compact('transactions'));
    }

    /**
     * @param CommissionCalculatorRequest $commissionCalculatorRequest
     * @return Factory|View|Application
     * @throws FileNotFoundException
     */
    public function calculate(CommissionCalculatorRequest $commissionCalculatorRequest): Factory|View|Application
    {
        $filePath = storage_path(
            'app/' . $commissionCalculatorRequest->file('customFile')
                ->storeAs('public/uploaded', 'import.csv')
        );
        $this->transactionImport->parseFromCSV($filePath);
        $transactions = ($this->transactionImport->getTransactions());
        $this->transactionService->setTransaction($transactions);
        $this->transactionService->calculateDeposit();
        $this->transactionService->calculateWithdrawPrivate();
        $this->transactionService->calculateWithdrawBusiness();
        return view('commission-calculator.index', compact('transactions'));
    }
}
