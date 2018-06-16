<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

/**
 * Class TransactionEntity
 *
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="transaction")
 * @method string getId()
 * @method void setId(string $id)
 * @method \App\Entity\AtmCard getAtmCard()
 * @method void setAtmCard(\App\Entity\AtmCard $atmCard)
 * @method \App\Entity\Account getAccount()
 * @method void setAccount(\App\Entity\Account $account)
 * @method float getAmount()
 * @method void setAmount(float $amount)
 * @method \DateTime getDateAdd()
 * @method void setDateAdd(\DateTime $dateAdd)
 */
class Transaction
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
     * @var AtmCard
     *
     * @Getter() @Setter()
     * @ORM\ManyToOne(targetEntity="AtmCard")
     */
    private $atmCard;

    /**
     * @var Account
     *
     * @Getter() @Setter()
     * @ORM\ManyToOne(targetEntity="Account")
     */
    private $account;

    /**
     * @var float
     *
     * @Getter() @Setter()
     * @ORM\Column(type="decimal", nullable=false, precision=10)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @Getter() @Setter()
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateAdd;

}