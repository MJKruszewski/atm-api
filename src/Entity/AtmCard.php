<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

/**
 * Class AtmCard
 *
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AtmCardRepository")
 * @ORM\Table(name="atm_card")
 * @method string getId()
 * @method void setId(string $id)
 * @method \App\Entity\Customer getCardOwner()
 * @method void setCardOwner(\App\Entity\Customer $cardOwner)
 * @method \App\Entity\Account getAccount()
 * @method void setAccount(\App\Entity\Account $account)
 */
class AtmCard
{
    /**
     * @var string
     *
     * @Getter()
     * @Setter()
     * @ORM\Id()
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=16, nullable=false)
     */
    private $cardNumber;

    /**
     * @var Customer
     *
     * @Getter() @Setter()
     * @ORM\ManyToOne(targetEntity="Customer")
     */
    private $cardOwner;

    /**
     * @var Account
     *
     * @Getter() @Setter()
     * @ORM\ManyToOne(targetEntity="Account", nullable=false)
     */
    private $account;

    /**
     * @var \DateTime
     *
     * @Getter() @Setter()
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @Getter() @Setter()
     * @ORM\Column(type="date", nullable=false)
     */
    private $expirationDate;

}