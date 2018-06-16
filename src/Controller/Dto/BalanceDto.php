<?php

namespace App\Controller\Dto;

use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

/**
 * Class BalanceDto
 *
 * @package App\Controller\Dto
 * @method string getUserId()
 * @method void setUserId(string $userId)
 * @method string getAccountNumber()
 * @method void setAccountNumber(string $accountNumber)
 */
class BalanceDto
{

    /**
     * @var string
     *
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
    private $accountNumber;

}