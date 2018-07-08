<?php

namespace App\Services;


use App\Controller\Dto\DepositDto;
use App\Controller\Dto\WithdrawDto;
use App\Entity\AtmCard;
use App\Entity\Transaction;
use App\Exceptions\AmountMustBeDivisibleException;
use App\Exceptions\AtmCardNotExist;
use App\Repository\AtmCardRepository;
use App\Repository\TransactionRepository;
use App\Services\Interfaces\AccountDepositInterface;
use App\Services\Interfaces\AccountWithdrawInterface;
use App\Services\Interfaces\RedisInterface;
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
     * @var RedisInterface
     */
    private $redis;

    /**
     * AccountOperationsService constructor.
     * @param AtmCardRepository $atmCardRepository
     * @param TransactionRepository $transactionRepository
     * @param RedisInterface $redis
     */
    public function __construct(AtmCardRepository $atmCardRepository, TransactionRepository $transactionRepository, RedisInterface $redis)
    {
        $this->atmCardRepository = $atmCardRepository;
        $this->transactionRepository = $transactionRepository;
        $this->redis = $redis;
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
        $this->redis->removeCache(
            AccountBalanceService::balanceCacheKey($atmCard->getCardOwner()->getId(), $atmCard->getAccount()->getAccountNumber())
        );
    }

    /**
     * @param DepositDto $depositDto
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function depositOnAccount(DepositDto $depositDto): void
    {
        $transaction = new Transaction();
        $transaction->setAmount($depositDto->getAmount());

        /** @var AtmCard $atmCard */
        $atmCard = $this->atmCardRepository->findOneBy([
            'cardNumber' => $depositDto->getCardNumber(),
            'cardOwner' => $depositDto->getUserId()
        ]);

        $transaction->setAtmCard($atmCard);
        $transaction->setAccount($atmCard->getAccount());
        $transaction->setDateAdd(new \DateTime());

        $this->transactionRepository->save($transaction);
    }

}