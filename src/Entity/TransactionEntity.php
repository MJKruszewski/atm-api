<?php
/**
 * Created by PhpStorm.
 * User: maciejkruszewski
 * Date: 15.06.2018
 * Time: 10:02
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

/**
 * Class TransactionEntity
 *
 * @package App\Entity
 * @ORM\Entity ()
 * @ORM\Table (name="transaction")
 * @method string getId()
 * @method void setId(string $id)
 */
class TransactionEntity
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