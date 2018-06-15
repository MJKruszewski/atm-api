<?php

namespace App\Repository;


use App\Entity\CustomerEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class CustomerRepository
 * @package App\Repository
 */
class CustomerRepository extends EntityRepository
{

    public function save(CustomerEntity $customerEntity) {
        $em = $this->getEntityManager();
        $em->persist($customerEntity);
        $em->flush($customerEntity);
    }

}