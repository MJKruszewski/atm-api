<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

/**
 * Class User
 *
 * @package App\Entity
 * @ORM\Entity (repositoryClass="App\Repository\CustomerRepository")
 * @ORM\Table (name="customer")
 * @method string getId()
 * @method void setId(string $id)
 */
class CustomerEntity
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

}