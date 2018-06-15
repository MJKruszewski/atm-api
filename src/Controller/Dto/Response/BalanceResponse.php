<?php

namespace App\Controller\Dto\Response;


use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

/**
 * Class BalanceResponse
 *
 * @method float getBalance()
 * @method void setBalance(float $balance)
 */
final class BalanceResponse
{
    /**
     * @var float
     *
     * @Getter()
     * @Setter()
     */
    private $balance;

}