<?php

namespace App\Controller\Rest;


use App\Controller\Dto\Response\BalanceResponse;
use App\Controller\Dto\UserDto;
use App\Controller\Dto\WithdrawDto;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AccountController
 * @package App\Controller\Rest
 *
 * @Rest\Route(path="/v1/account")
 */
class AccountController extends FOSRestController
{
    /**
     * @param UserDto $userDto
     * @return JsonResponse
     *
     * @ParamConverter(name="userDto", class="App\Controller\Dto\UserDto", converter="dto_converter")
     * @Rest\Get()
     * @Rest\Route(path="/balance")
     */
    public function getBalance(UserDto $userDto): JsonResponse
    {
        $response = new BalanceResponse();
        $response->setBalance(111.11);

        return $this->json($response);
    }

    /**
     * @param WithdrawDto $withdrawDto
     * @return JsonResponse
     *
     * @Rest\Post()
     * @Rest\Route(path="/withdraw")
     * @ParamConverter(name="withdrawDto", class="App\Controller\Dto\WithdrawDto", converter="dto_converter")
     */
    public function postWithdraw(WithdrawDto $withdrawDto): JsonResponse
    {

    }


}