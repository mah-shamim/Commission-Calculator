<?php


namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class TransactionService
{
    /**
     * @var Collection $transactions
     */
    private Collection $transactions;

    /**
     * @param $transactions
     */
    public function setTransaction($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * Deposit Charge Calculate
     */
    public function calculateDeposit()
    {
        $returnData = new DepositCommission($this->transactions->where('operation_type','deposit'));
        $this->transactions->merge($returnData->calculate());
    }

    /**
     * Business Withdraw Charge Calculate
     */
    public function calculateWithdrawBusiness()
    {
        $returnData = new WithdrawBusinessCommission(
            $this->transactions
                ->where('operation_type','withdraw')
                ->where('user_type','business')
        );
        $this->transactions->merge($returnData->calculate());
    }

    /**
     * Business Private Charge Calculate
     */
    public function calculateWithdrawPrivate()
    {
        $returnData = new WithdrawPrivateCommission(
            $this->transactions
                ->where('operation_type','withdraw')
                ->where('user_type','private')
        );
        $this->transactions->merge($returnData->calculate());
    }

}
