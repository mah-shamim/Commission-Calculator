<?php

namespace App\Interfaces;

interface CommissionTypeInterface
{
    /**
     * @return mixed
     */
    public function calculate(): mixed;
}
