<?php

namespace App\Services;


use App\Controller\Dto\WithdrawDto;

interface AccountWithdrawInterface
{

    /**
     * @param WithdrawDto $withdrawDto
     */
    public function withdrawFromAccount(WithdrawDto $withdrawDto): void;

}