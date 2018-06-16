<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Plumbok\Annotation\Getter;

/**
 * Class Account
 *
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 * @ORM\Table(name="account")
 * @method string getId()
 * @method void setId(string $id)
 * @method string getAccountNumber()
 * @method void setAccountNumber(string $accountNumber)
 * @method \App\Entity\Customer getAccountOwner()
 * @method void setAccountOwner(\App\Entity\Customer $accountOwner)
 */
class Account
{

    /**
     * @var string
     *
     * @Getter() @Setter()
     * @ORM\Id()
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @Getter() @Setter()
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private $accountNumber;

    /**
     * @var Customer
     *
     * @Getter() @Setter()
     * @ORM\ManyToOne(targetEntity="Customer")
     */
    private $accountOwner;

    /**
     * @var \DateTime
     *
     * @Getter() @Setter()
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateAdd;

}