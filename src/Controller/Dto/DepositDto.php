<?php

namespace App\Controller\Dto;

use Plumbok\Annotation\Data;

/**
 * Class DepositDto
 *
 * @Data()
 * @package App\Controller\Dto
 * @method void __construct(null | string $userId, float $amount, string $cardNumber)
 * @method null|string getUserId()
 * @method void setUserId(null | string $userId)
 * @method float getAmount()
 * @method void setAmount(float $amount)
 * @method string getCardNumber()
 * @method void setCardNumber(string $cardNumber)
 */
final class DepositDto
{

    /**
     * @var null|string
     *
     */
    private $userId;

    /**
     * @var float
     *
     */
    private $amount;

    /**
     * @var string
     *
     */
    private $cardNumber;

}