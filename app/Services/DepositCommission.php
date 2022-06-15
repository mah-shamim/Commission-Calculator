<?php


namespace App\Services;


use App\Interfaces\CommissionTypeInterface;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\Pure;

class DepositCommission implements CommissionTypeInterface
{

    /**
     * @var float
     */
    public const COMMISSION_PERCENTAGE = 0.03;
    //public const DEFAULT_CURRENCY = 'EUR';

    /**
     * @var Collection $transactions
     */
    private Collection $transactions;
    private CurrencyService $currencyService;
    private CommissionService $commissionService;

    /**
     * DepositCommission constructor.
     * @param $transactions
     */
    #[Pure] public function __construct($transactions)
    {

        $this->transactions = $transactions;
        $this->currencyService = new CurrencyService();
        $this->commissionService = new CommissionService();
    }

    /**
     * @return Collection
     */
    public function calculate(): Collection
    {
        foreach ($this->transactions as $key => $transaction):
            $convertedAmount = $this->currencyService->convertedAmount(
                $transaction->operation_amount,
                $transaction->operation_currency
            );
            $this->transactions[$key]->converted_operation_amount = $convertedAmount;
            $this->transactions[$key]->commission_amount = $this->currencyService->precision(
                $this->commissionService->commissionAmount($convertedAmount, self::COMMISSION_PERCENTAGE),
                $transaction->operation_currency
            );
        endforeach;
        return $this->transactions;
    }
}