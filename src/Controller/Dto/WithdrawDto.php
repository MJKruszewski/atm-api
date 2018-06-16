<?php

namespace App\Controller\Dto;


use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

/**
 * Class WithdrawDto
 *
 * @method string getUserId()
 * @method void setUserId(string $userId)
 * @method float getAmount()
 * @method void setAmount(float $amount)
 */
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