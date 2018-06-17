<?php

namespace App\Controller\Rest\Docs;


use App\Controller\Dto\BalanceDto;
use App\Controller\Dto\WithdrawDto;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface AccountInterface
 * @package App\Controller\Rest\Docs
 *
 * @SWG\Tag(
 *     name="account",
 *     description="Account Operations"
 * )
 */
interface AccountInterface extends ApiDocInterface
{
    /**
     * @SWG\Get(
     *     path="/account/balance/{userId}/{accountNumber}",
     *     summary="Get account balance",
     *     operationId="getBalance",
     *     produces={"application/json"},
     *     tags={"account"},
     *     @SWG\Parameter(
     *          name="userId",
     *          description="Customer UUID",
     *          in="path",
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="accountNumber",
     *          description="User account number",
     *          in="path",
     *          type="string"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="OK",
     *          @SWG\Schema(ref="#/definitions/BalanceResponseDto")
     *     )
     * )
     *
     */
    public function getBalance(BalanceDto $balanceDto): JsonResponse;

    /**
     * @SWG\Post(
     *     path="/account/withdraw",
     *     summary="Withdraw from account",
     *     description="Method allows user to withdraw from defined account by atm card",
     *     operationId="postWithdraw",
     *     produces={"application/json"},
     *     tags={"account"},
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/WithdrawDto")
     *     ),
     *     @SWG\Response(
     *          response=204,
     *          description="No content",
     *     )
     * )
     */
    public function postWithdraw(WithdrawDto $withdrawDto): JsonResponse;

}