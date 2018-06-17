<?php

namespace App\Services;


use App\Controller\Dto\DepositDto;
use App\Controller\Dto\WithdrawDto;
use App\Entity\AtmCard;
use App\Exceptions\AmountMustBeDivisibleException;
use App\Exceptions\AtmCardNotExist;
use App\Repository\AtmCardRepository;
use App\Repository\TransactionRepository;
use App\Services\Interfaces\AccountDepositInterface;
use App\Services\Interfaces\AccountWithdrawInterface;
use Symfony\Component\HttpFoundation\Response;

final class AccountOperationsService implements AccountWithdrawInterface, AccountDepositInterface
{

    /**
     * @var AtmCardRepository
     */
    private $atmCardRepository;
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * AccountOperationsService constructor.
     * @param AtmCardRepository $atmCardRepository
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(AtmCardRepository $atmCardRepository, TransactionRepository $transactionRepository)
    {
        $this->atmCardRepository = $atmCardRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param WithdrawDto $withdrawDto
     * @throws \Doctrine\DBAL\DBALException
     * @throws AmountMustBeDivisibleException
     * @throws AtmCardNotExist
     */
    public function withdrawFromAccount(WithdrawDto $withdrawDto): void
    {
        if ($withdrawDto->getAmount() % 20 !== 0) {
            throw new AmountMustBeDivisibleException('Amount must be divisible by 20', Response::HTTP_BAD_REQUEST);
        }

        /** @var AtmCard $atmCard */
        $atmCard = $this->atmCardRepository->findOneBy([
            'cardOwner' => $withdrawDto->getUserId(),
            'cardNumber' => $withdrawDto->getCardNumber()
        ]);

        if (!$atmCard) {
            throw new AtmCardNotExist('ATM card does not exists', Response::HTTP_NOT_FOUND);
        }

        $this->transactionRepository->withdrawFromAccount($atmCard, $withdrawDto->getAmount());
    }

    /**
     * @param DepositDto $depositDto
     */
    public function depositOnAccount(DepositDto $depositDto): void
    {

    }

}