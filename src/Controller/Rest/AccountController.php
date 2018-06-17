<?php

namespace App\Controller\Rest;

use App\Controller\Dto\BalanceDto;
use App\Controller\Dto\DepositDto;
use App\Controller\Dto\Responses\BalanceResponseDto;
use App\Controller\Dto\WithdrawDto;
use App\Controller\Rest\Docs\AccountInterface;
use App\Exceptions\ApiException;
use App\Services\AccountOperationsService;
use App\Services\Interfaces\AccountBalanceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AccountController
 * @package App\Controller\Rest
 *
 * @Rest\Route(path="/v1/account")
 */
final class AccountController extends FOSRestController implements AccountInterface
{
    /**
     * @var AccountOperationsService
     */
    private $accountOperationsService;

    /**
     * @var AccountBalanceInterface
     */
    private $accountBalanceService;

    /**
     * AccountController constructor.
     * @param AccountOperationsService $accountOperationsService
     * @param AccountBalanceInterface $accountBalanceService
     */
    public function __construct(AccountOperationsService $accountOperationsService, AccountBalanceInterface $accountBalanceService)
    {
        $this->accountOperationsService = $accountOperationsService;
        $this->accountBalanceService = $accountBalanceService;
    }

    /**
     * @param BalanceDto $balanceDto
     * @return JsonResponse
     *
     * @ParamConverter(name="balanceDto", class="App\Controller\Dto\BalanceDto", converter="dto_converter")
     * @Rest\Get(path="/balance/{userId}/{accountNumber}")
     */
    public function getBalance(BalanceDto $balanceDto): JsonResponse
    {
        $response = new BalanceResponseDto();
        try {
            $balance = $this->accountBalanceService->calculateAccountBalance($balanceDto);
            $response->setStatusCode(Response::HTTP_OK);
            $response->setBalance($balance);
        } catch (ApiException | \Exception $e) {
            $response = ApiException::handleApiException($e, $response);
        }

        return $response;
    }

    /**
     * @param WithdrawDto $withdrawDto
     * @return JsonResponse
     *
     * @Rest\Post(path="/withdraw", requirements={"_format"="json"})
     * @ParamConverter(name="withdrawDto", class="App\Controller\Dto\WithdrawDto", converter="dto_converter")
     */
    public function postWithdraw(WithdrawDto $withdrawDto): JsonResponse
    {
        $response = new JsonResponse();
        try {
            $this->accountOperationsService->withdrawFromAccount($withdrawDto);
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
            $response->setContent(null);
        } catch (ApiException | \Exception $e) {
            $response = ApiException::handleApiException($e, $response);
        }

        return $response;
    }

    /**
     * @param DepositDto $depositDto
     * @return JsonResponse
     *
     * @Rest\Post(path="/withdraw", requirements={"_format"="json"})
     * @ParamConverter(name="depositDto", class="App\Controller\Dto\DepositDto", converter="dto_converter")
     */
    public function postDeposit(DepositDto $depositDto): JsonResponse
    {

    }


}