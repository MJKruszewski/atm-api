<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\AtmCard;


/**
 * Class TransactionRepository
 * @package App\Repository
 */
class TransactionRepository extends AbstractRepository
{

    /**
     * @param Account $account
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getAccountBalance(Account $account): float
    {
        $query = $this
            ->getEntityManager()
            ->getConnection()
            ->prepare('SELECT account_balance(:account_id) as balance');

        $query->execute([
            'account_id' => $account->getId()
        ]);
        return (float)$query->fetch()['balance'] ?? 0;
    }

    /**
     * @param AtmCard $atmCard
     * @param float $amount
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function withdrawFromAccount(AtmCard $atmCard, float $amount)
    {
        $query = $this
            ->getEntityManager()
            ->getConnection()
            ->prepare('SELECT withdraw(:account_id, :atm_card_id, :withdraw_amount);');

        $query->execute([
            'account_id' => $atmCard->getAccount()->getId(),
            'atm_card_id' => $atmCard->getId(),
            'withdraw_amount' => $amount,
        ]);
        return $query->fetch();
    }

}