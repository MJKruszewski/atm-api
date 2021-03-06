<?php

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractRepository
 * @package App\Repository
 *
 */
abstract class AbstractRepository extends EntityRepository
{

    /**
     * @param $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
    }
}