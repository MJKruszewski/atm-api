<?php

namespace App\Services\Interfaces;


use App\Controller\Dto\DepositDto;

interface AccountDepositInterface
{

    public function depositOnAccount(DepositDto $depositDto): void;

}