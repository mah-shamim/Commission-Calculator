<?php


namespace App\Services;


class CommissionService
{
    /**
     * @param $amount
     * @param $commission
     * @return float|int
     */
    public function commissionAmount($amount, $commission): float|int
    {
        return $amount * ($commission / 100);
    }
}