<?php


namespace App\Services;


use App\Interfaces\CommissionTypeInterface;

class WithdrawPrivateCommission implements CommissionTypeInterface
{
    /**
     * @var float
     */
    const COMMISSION_PERCENTAGE = 0.3;
    const WITHDRAW_PRIVET_MAX_TRANSACTION_FREQUENCY = 3;
    const WITHDRAW_PRIVET_FREE_AMOUNT = 1000;
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
            $this->transactions[$key]->transaction_frequency = $this->getPreviousTransactionFrequency($transaction)->count();
            if ($this->transactions[$key]->transaction_frequency > self::WITHDRAW_PRIVET_MAX_TRANSACTION_FREQUENCY):
                        $this->transactions[$key]->commission_amount = $this->commissionService->commissionAmount($convertedAmount, self::COMMISSION_PERCENTAGE);
                    else:
                        $previousTransactions = $this->getPreviousTransactionFrequency($transaction);
                        if ($previousTransactions->count() > 0) {
                            $tempAmount = self::WITHDRAW_PRIVET_FREE_AMOUNT;
                            foreach ($previousTransactions as $previousTransaction):
                                $tempAmount = $tempAmount - $previousTransaction->converted_operation_amount;
                                if ($tempAmount < 0):
                                    break;
                                endif;
                            endforeach;
                            if ($tempAmount <= 0) {
                                $this->transactions[$key]->commission_amount = $this->commissionService->commissionAmount(($transaction->converted_operation_amount), self::COMMISSION_PERCENTAGE);
                            } else {
                                $this->transactions[$key]->commission_amount = $this->commissionService->commissionAmount(($transaction->converted_operation_amount - $tempAmount), self::COMMISSION_PERCENTAGE);
                            }

                        } else if ($this->transactions[$key]->converted_operation_amount <= self::WITHDRAW_PRIVET_FREE_AMOUNT) {
                            $this->transactions[$key]->commission_amount = $this->commissionService->commissionAmount(0, self::COMMISSION_PERCENTAGE);
                        } else {
                            $this->transactions[$key]->commission_amount = $this->commissionService->commissionAmount(($this->transactions[$key]->converted_operation_amount - self::WITHDRAW_PRIVET_FREE_AMOUNT), 0.3);
                        }
                    endif;

            $this->transactions[$key]->commission_amount = $this->currencyService->precision($this->transactions[$key]->commission_amount, $transaction->operation_currency);
        endforeach;
        return $this->transactions;
    }

    /**
     * @param $transaction
     * @return mixed
     */
    public function getPreviousTransactionFrequency($transaction): mixed
    {
        return $this->transactions
            ->where('week_number_year', '=', $transaction->week_number_year)
            ->where('operation_date', '<=', $transaction->operation_date)
            ->where('transaction_id', '<', $transaction->transaction_id)
            ->where('user_identification', '=', $transaction->user_identification)
            ->where('operation_type', 'withdraw')
            ->where('user_type', 'private')
            ->sortBy('transaction_id');
    }
}