<?php

namespace App\Exceptions;

use Doctrine\DBAL\DBALException;
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
            'msg' => self::prepareErrorMessage($e),
            'errorCode' => self::prepareErrorCode($e)
        ]);

        return $response;
    }

    /**
     * @param \Exception $e
     * @return string
     */
    private static function prepareErrorCode(\Exception $e): string
    {
        switch ($e) {
            case $e instanceof ApiException:
                return $e->getErrorCode() ?? ApiException::GENERAL_ERROR_CODE;
            case $e instanceof DBALException:
                return 'V' . ($e->getSQLState() ?? ApiException::GENERAL_ERROR_CODE);
            default:
                return ApiException::GENERAL_ERROR_CODE;
        }
    }

    /**
     * @param \Exception $e
     * @return string
     */
    private static function prepareErrorMessage(\Exception $e): string
    {
        switch ($e) {
            case $e instanceof DBALException:
                return preg_replace('/((.*)(\n*)(SQLSTATE\[[0-9]*\]: <<Unknown error>>: [0-9]*\s)(.*\z))/m', '$5', $e->getMessage());
            default:
                return $e->getMessage();
        }
    }


}