<?php

namespace App\Controller\Dto\Responses;

use Plumbok\Annotation\Getter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class BanalceResponseDto
 *
 * @SWG\Definition()
 * @package App\Controller\Dto\Responses
 * @method float getBalance()
 */
final class BalanceResponseDto extends JsonResponse
{

    /**
     * @var float
     *
     * @SWG\Property()
     * @Getter()
     */
    private $balance;

    /**
     * @param float $balance
     */
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
        $this->setData(['balance' => $this->balance]);
    }

}