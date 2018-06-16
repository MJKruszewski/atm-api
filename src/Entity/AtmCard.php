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
 * @method \DateTime getDateAdd()
 * @method void setDateAdd(\DateTime $dateAdd)
 * @method \DateTime getExpirationDate()
 * @method void setExpirationDate(\DateTime $expirationDate)
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
     * @ORM\ManyToOne(targetEntity="Account")
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