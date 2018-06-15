<?php

namespace App\Controller\Dto;


use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

/**
 * Class UserDto
 *
 * @method string getId()
 * @method void setId(string $id)
 */
final class UserDto
{
    /**
     * @var string
     *
     * @Getter()
     * @Setter()
     */
    private $id;

}