<?php

namespace App\Services;


use App\Controller\Dto\BalanceDto;
use App\Entity\Account;
use App\Exceptions\AccountNotExists;
use App\Repository\AccountRepository;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Response;

final class AccountBalanceService
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * AccountBalanceService constructor.
     * @param AccountRepository $accountRepository
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(AccountRepository $accountRepository, TransactionRepository $transactionRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param BalanceDto $balanceDto
     * @return float
     * @throws \Doctrine\DBAL\DBALException
     * @throws AccountNotExists
     */
    public function calculateAccountBalance(BalanceDto $balanceDto): float
    {
        /** @var Account $account */
        $account = $this->accountRepository->findOneBy([
            'accountNumber' => $balanceDto->getAccountNumber(),
            'accountOwner' => $balanceDto->getUserId()
        ]);

        if (!$account) {
            throw new AccountNotExists('Account does not exists', Response::HTTP_NOT_FOUND);
        }

        return $this->transactionRepository->getAccountBalance($account);
    }

}