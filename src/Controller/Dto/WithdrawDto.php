<?php

namespace App\Controller\Dto;


use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

final class WithdrawDto
{
    /**
     * @var string
     *
     * @Getter()
     * @Setter()
     */
    private $userId;

    /**
     * @var float
     *
     * @Getter()
     * @Setter()
     */
    private $amount;

}