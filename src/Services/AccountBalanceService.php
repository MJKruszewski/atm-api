<?php

namespace App\Services;


use App\Controller\Dto\BalanceDto;
use App\Entity\Account;
use App\Exceptions\AccountNotExists;
use App\Repository\AccountRepository;
use App\Repository\TransactionRepository;
use App\Services\Interfaces\AccountBalanceInterface;
use App\Services\Interfaces\RedisInterface;
use Symfony\Component\HttpFoundation\Response;

final class AccountBalanceService implements AccountBalanceInterface
{

    const CACHE_LIFETIME = 900;

    /**
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;
    /**
     * @var RedisInterface
     */
    private $redis;

    /**
     * AccountBalanceService constructor.
     * @param AccountRepository $accountRepository
     * @param TransactionRepository $transactionRepository
     * @param RedisInterface $redis
     */
    public function __construct(AccountRepository $accountRepository, TransactionRepository $transactionRepository, RedisInterface $redis)
    {
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
        $this->redis = $redis;
    }

    /**
     * @param BalanceDto $balanceDto
     * @return float
     * @throws \Doctrine\DBAL\DBALException
     * @throws AccountNotExists
     */
    public function calculateAccountBalance(BalanceDto $balanceDto): float
    {
        $cacheKey = self::balanceCacheKey($balanceDto->getUserId(), $balanceDto->getAccountNumber());
        $cache = $this->redis->readCache($cacheKey);

        if ($cache) {
            return (float)$cache;
        }

        /** @var Account $account */
        $account = $this->accountRepository->findOneBy([
            'accountNumber' => $balanceDto->getAccountNumber(),
            'accountOwner' => $balanceDto->getUserId()
        ]);

        if (!$account) {
            throw new AccountNotExists('Account does not exists', Response::HTTP_NOT_FOUND);
        }

        $balance = $this->transactionRepository->getAccountBalance($account);
        $this->redis->addCache($cacheKey, $balance, self::CACHE_LIFETIME);

        return $balance;
    }

    /**
     * @param string $userId
     * @param string $accountNumber
     * @return string
     */
    public static function balanceCacheKey(string $userId, string $accountNumber): string
    {
        return 'balance_' . $userId . '_' . $accountNumber;
    }

}