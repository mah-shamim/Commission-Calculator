<?php


namespace App\Services;


use App\Interfaces\CommissionTypeInterface;

class WithdrawBusinessCommission implements CommissionTypeInterface
{

    /**
     * @var float
     */
    const COMMISSION_PERCENTAGE = 0.5;
    const DEFAULT_CURRENCY = 'EUR';

    private $transactions;
    private CurrencyService $currencyService;
    private CommissionService $commissionService;


    /**
     * DepositCommission constructor.
     * @param $transactions
     */
    public function __construct($transactions)
    {

        $this->transactions = $transactions;
        $this->currencyService = new CurrencyService();
        $this->commissionService = new CommissionService();
    }

    public function calculate(): mixed
    {
        foreach ($this->transactions as $key => $transaction):
            $convertedAmount = $this->currencyService->convertedAmount(
                $transaction->operation_amount,
                $transaction->operation_currency
            );
            $this->transactions[$key]->converted_operation_amount = $convertedAmount;
            $this->transactions[$key]->commission_amount = $this->commissionService->commissionAmount(
                    $convertedAmount, self::COMMISSION_PERCENTAGE
            );
            $this->transactions[$key]->commission_amount = $this->currencyService->precision(
                $this->transactions[$key]->commission_amount,
                $transaction->operation_currency
            );
        endforeach;
        return $this->transactions;
    }
}