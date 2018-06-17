<?php

namespace App\Services\Interfaces;


use App\Controller\Dto\BalanceDto;

interface AccountBalanceInterface
{

    /**
     * @param BalanceDto $balanceDto
     * @return float
     */
    public function calculateAccountBalance(BalanceDto $balanceDto): float;

}