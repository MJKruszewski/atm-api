<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class ApiException
 */
abstract class ApiException extends \Exception
{
    const GENERAL_ERROR_CODE = 'V00001';

    /**
     * @var string
     */
    private $errorCode;
    /**
     * @var int|null
     */
    private $httpStatusCode;

    /**
     * ApiException constructor.
     * @param string $message
     * @param int|null $httpStatusCode
     * @param string|null $errorCode
     * @param int $code
     */
    public function __construct($message = "", ?int $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR, ?string $errorCode = null, $code = 0)
    {
        $this->errorCode = $errorCode;
        $this->httpStatusCode = $httpStatusCode;
        parent::__construct($message, $code);
    }

    /**
     * @return int|null
     */
    public function getHttpStatusCode(): ?int
    {
        return $this->httpStatusCode;
    }

    /**
     * @return string
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * @param \Exception $e
     * @param JsonResponse $response
     * @return JsonResponse
     */
    public static function handleApiException(\Exception $e, JsonResponse $response): JsonResponse
    {
        $response->setStatusCode($e instanceof ApiException ? $e->getHttpStatusCode() ?? Response::HTTP_BAD_REQUEST : Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->setData([
            'msg' => $e->getMessage(),
            'errorCode' => $e instanceof ApiException ? $e->getErrorCode() ?? ApiException::GENERAL_ERROR_CODE : ApiException::GENERAL_ERROR_CODE
        ]);

        return $response;
    }


}