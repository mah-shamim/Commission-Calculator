<?php


namespace App\Services;


use App\Interfaces\CommissionTypeInterface;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\Pure;

class WithdrawBusinessCommission implements CommissionTypeInterface
{

    /**
     * @var float
     */
    public const COMMISSION_PERCENTAGE = 0.5;
    //public const DEFAULT_CURRENCY = 'EUR';

    /**
     * @var Collection $transactions
     */
    private Collection $transactions;
    private CurrencyService $currencyService;
    private CommissionService $commissionService;


    /**
     * WithdrawBusinessCommission constructor.
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