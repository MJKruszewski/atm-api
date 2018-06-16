<?php

namespace tests\Services;

use App\Controller\Dto\WithdrawDto;
use App\Entity\AtmCard;
use App\Exceptions\AmountMustBeDivisibleException;
use App\Exceptions\AtmCardNotExist;
use App\Kernel;
use App\Repository\AtmCardRepository;
use App\Repository\TransactionRepository;
use App\Services\AccountOperationsService;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class AccountOperationsServiceTest extends TestCase
{

    /**
     * @var AccountOperationsService
     */
    private $service;
    /**
     * @var AtmCardRepository|MockObject
     */
    private $atmRepository;
    /**
     * @var TransactionRepository|MockObject
     */
    private $transactionRepository;

    /**
     * @before
     */
    public function prepareService()
    {
        $kernel = new Kernel('dev', false);
        $kernel->registerPlumbok();

        $this->atmRepository = $this->createMock(AtmCardRepository::class);
        $this->transactionRepository = $this->createMock(TransactionRepository::class);

        $this->service = new AccountOperationsService(
            $this->atmRepository,
            $this->transactionRepository
        );
    }

    /**
     * @dataProvider divisableProvider
     *
     * @param float $amount
     * @throws AmountMustBeDivisibleException
     * @throws AtmCardNotExist
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testWithdrawFromAccount(float $amount): void
    {
        $this->atmRepository->method('findOneBy')->willReturn(new AtmCard());

        $dto = new WithdrawDto();
        $dto->setAmount($amount);
        $dto->setUserId("");
        $dto->setCardNumber("");
        $this->assertNull($this->service->withdrawFromAccount($dto));
    }

    /**
     * @dataProvider notDivisibleProvider
     *
     * @param float $amount
     * @throws AmountMustBeDivisibleException
     * @throws \App\Exceptions\AtmCardNotExist
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testDivisibleException(float $amount): void
    {
        $this->expectException(AmountMustBeDivisibleException::class);
        $this->expectExceptionMessage('Amount must be divisible by 20');

        $dto = new WithdrawDto();
        $dto->setAmount($amount);
        $dto->setUserId("");
        $dto->setCardNumber("");
        try {
            $this->service->withdrawFromAccount($dto);
        } catch (AmountMustBeDivisibleException $e) {
            $this->assertEquals(Response::HTTP_BAD_REQUEST, $e->getHttpStatusCode());
            throw $e;
        }
    }


    /**
     * @dataProvider divisableProvider
     *
     * @param float $amount
     * @throws AmountMustBeDivisibleException
     * @throws AtmCardNotExist
     * @throws \Doctrine\DBAL\DBALException
     */
    public function testAtmCardNotExist(float $amount): void
    {
        $this->expectException(AtmCardNotExist::class);
        $this->expectExceptionMessage('ATM card does not exists');

        $dto = new WithdrawDto();
        $dto->setAmount($amount);
        $dto->setUserId("");
        $dto->setCardNumber("");
        try {
            $this->service->withdrawFromAccount($dto);
        } catch (AtmCardNotExist $e) {
            $this->assertEquals(Response::HTTP_NOT_FOUND, $e->getHttpStatusCode());
            throw $e;
        }
    }

    /**
     * @return array
     */
    public function divisableProvider(): array
    {
        return [
            [20.0],
            [40.0],
            [1000.0],
            [5840.0],
            [100.0],
            [160.0]
        ];
    }

    public function notDivisibleProvider(): array
    {
        return [
            [13.0],
            [21.0],
            [2.0],
            [68.0],
            [90.0],
            [110.0]
        ];
    }
}
