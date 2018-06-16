<?php

namespace App\Controller\Dto;


use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;
use Swagger\Annotations as SWG;

/**
 * Class WithdrawDto
 *
 * @SWG\Definition()
 * @method string getUserId()
 * @method void setUserId(string $userId)
 * @method string getCardNumber()
 * @method void setCardNumber(string $cardNumber)
 * @method float getAmount()
 * @method void setAmount(float $amount)
 */
final class WithdrawDto
{
    /**
     * @var string
     *
     * @SWG\Property()
     * @Getter()
     * @Setter()
     */
    private $userId;

    /**
     * @var string
     *
     * @Getter()
     * @Setter()
     */
    private $cardNumber;

    /**
     * @var float
     *
     * @SWG\Property()
     * @Getter()
     * @Setter()
     */
    private $amount;

}