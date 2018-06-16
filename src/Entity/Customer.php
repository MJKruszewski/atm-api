<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

/**
 * Class User
 *
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\Table(name="customer")
 * @method string getId()
 * @method void setId(string $id)
 * @method string getName()
 * @method void setName(string $name)
 * @method string getSecondName()
 * @method void setSecondName(string $secondName)
 * @method string getSurname()
 * @method void setSurname(string $surname)
 * @method \DateTime getDateAdd()
 * @method void setDateAdd(\DateTime $dateAdd)
 */
class Customer
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
     * @Getter() @Setter()
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @var string
     *
     * @Getter() @Setter()
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $secondName;

    /**
     * @var string
     *
     * @Getter() @Setter()
     * @ORM\Column(type="string", length=30)
     */
    private $surname;

    /**
     * @var \DateTime
     *
     * @Getter() @Setter()
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateAdd;

}