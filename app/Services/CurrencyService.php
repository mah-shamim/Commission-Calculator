<?php


namespace App\Services;


use Exception;

class CurrencyService
{
    /**
     * @param $amount
     * @param $operation_currency
     * @return float|int
     */
    public function convertedAmount($amount, $operation_currency): float|int
    {
        return $amount / $this->getCurrencyRate($operation_currency);
    }

    /**
     * @param $amount
     * @param $operation_currency
     * @return float|int
     */
    public function reverseAmount($amount, $operation_currency): float|int
    {
        return $amount * $this->getCurrencyRate($operation_currency);
    }


    /**
     * @param $currency
     * @return Exception|mixed|string
     */
    public function getCurrencyRate($currency): mixed
    {
        try {
            $rateData = file_get_contents('https://developers.paysera.com/tasks/api/currency-exchange-rates');

            $data = json_decode($rateData, true);
            return (isset($data['rates'][$currency])) ? $data['rates'][$currency] : '-1';
        }catch (Exception $exception){
            return $exception;
        }
    }

    /**
     * @param $commission_amount
     * @param $operation_currency
     * @param $precision
     * @return float|string
     */
    public function precision($commission_amount, $operation_currency): float|string
    {
        $currencyFormat = config("money.{$operation_currency}");
        if ($currencyFormat['precision'] > 0) {
            $chargeAmount = number_format($this->reverseAmount($commission_amount, $operation_currency), $currencyFormat['precision'], ".", "");
        } else {
            $chargeAmount = ceil($this->reverseAmount($commission_amount, $operation_currency));
        }
        return $chargeAmount;
    }
}