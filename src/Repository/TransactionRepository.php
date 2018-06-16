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
    public function getAccountBalance(Account $account)
    {
        $query = $this
            ->getEntityManager()
            ->getConnection()
            ->prepare('SELECT account_balance(:account_id::VARCHAR);');

        $query->bindValue(':account_id', $account->getId());
        $query->execute();
        return $query->fetch();
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
            ->prepare('SELECT withdraw(:account_id::VARCHAR, :atm_card_id::VARCHAR, :withdraw_amount::DECIMAL,);');

        $query->bindValue(':account_id', $atmCard->getAccount()->getId());
        $query->bindValue(':atm_card_id', $atmCard->getId());
        $query->bindValue(':withdraw_amount', $amount);
        $query->execute();
        return $query->fetch();
    }

}