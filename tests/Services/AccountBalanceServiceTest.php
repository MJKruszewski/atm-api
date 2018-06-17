<?php

namespace Services;

use App\Controller\Dto\BalanceDto;
use App\Entity\Account;
use App\Exceptions\AccountNotExists;
use App\Kernel;
use App\Repository\AccountRepository;
use App\Repository\TransactionRepository;
use App\Services\AccountBalanceService;
use App\Services\Interfaces\RedisInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class AccountBalanceServiceTest extends TestCase
{
    /**
     * @var AccountBalanceService
     */
    private $service;
    /**
     * @var AccountRepository|MockObject
     */
    private $accountRepository;
    /**
     * @var TransactionRepository|MockObject
     */
    private $transactionRepository;
    /**
     * @var RedisInterface|MockObject
     */
    private $redis;

    /**
     * @before
     */
    public function prepareService()
    {
        $kernel = new Kernel('dev', false);
        $kernel->registerPlumbok();

        $this->accountRepository = $this->createMock(AccountRepository::class);
        $this->transactionRepository = $this->createMock(TransactionRepository::class);
        $this->redis = $this->createMock(RedisInterface::class);

        $this->service = new AccountBalanceService(
            $this->accountRepository,
            $this->transactionRepository,
            $this->redis
        );
    }

    /**
     * @throws AccountNotExists
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testAccountNotExists()
    {
        $this->expectException(AccountNotExists::class);
        $this->expectExceptionMessage('Account does not exists');

        $dto = new BalanceDto();
        $dto->setUserId('uuid');
        $dto->setAccountNumber('111');

        try {
            $this->service->calculateAccountBalance($dto);
        } catch (AccountNotExists $e) {
            $this->assertEquals(Response::HTTP_NOT_FOUND, $e->getHttpStatusCode());
            throw $e;
        }
    }

    /**
     * @throws AccountNotExists
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testCalculateAccountBalance()
    {
        $dto = new BalanceDto();
        $dto->setUserId('uuid');
        $dto->setAccountNumber('111');

        $this->accountRepository->method('findOneBy')->willReturn(new Account());
        $this->transactionRepository->method('getAccountBalance')->willReturn(500);

        $balance = $this->service->calculateAccountBalance($dto);

        $this->assertEquals(500, $balance);
    }

    public function testRedisCache()
    {
        $dto = new BalanceDto();
        $dto->setUserId('uuid');
        $dto->setAccountNumber('111');

        $this->redis->method('readCache')->willReturn(400);

        $balance = $this->service->calculateAccountBalance($dto);

        $this->assertEquals(400, $balance);
    }
}
