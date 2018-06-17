<?php

namespace App\Services;


use App\Controller\Dto\DepositDto;

interface AccountDepositInterface
{

    public function depositOnAccount(DepositDto $depositDto): void;

}