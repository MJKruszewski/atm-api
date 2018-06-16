<?php

namespace App\Controller\Dto;

use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;
use Swagger\Annotations as SWG;

/**
 * Class BalanceDto
 *
 * @SWG\Definition()
 * @package App\Controller\Dto
 * @method string getUserId()
 * @method void setUserId(string $userId)
 * @method string getAccountNumber()
 * @method void setAccountNumber(string $accountNumber)
 */
final class BalanceDto
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
     * @SWG\Property()
     * @Getter()
     * @Setter()
     */
    private $accountNumber;

}