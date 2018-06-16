<?php

namespace App\Exceptions;


use Plumbok\Annotation\Getter;
use Plumbok\Annotation\Setter;

/**
 * Class ApiException
 *
 * @method string getErrorCode()
 * @method void setErrorCode(string $errorCode)
 */
abstract class ApiException extends \Exception
{
    const GENERAL_ERROR_CODE = 'V00001';

    /**
     * @Getter()
     * @Setter()
     * @var string
     */
    private $errorCode;

    /**
     * ApiException constructor.
     * @param string $message
     * @param int $code
     * @param string|null $errorCode
     */
    public function __construct($message = "", $code = 0, ?string $errorCode = null)
    {
        $this->errorCode = $errorCode;
        parent::__construct($message, $code);
    }


}