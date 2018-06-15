<?php

namespace App\Converter;


use Psr\Log\LoggerInterface;
use ReflectionClass;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

final class DtoConverter implements ParamConverterInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * DtoConverter constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Stores the object in the request.
     *
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $dto = null;
        $class = $configuration->getClass();

        try {
            $dto = new $class();
            $reflection = new ReflectionClass($dto);

            if ($dto === null) {
                return $configuration->isOptional() || !empty($dto);
            }

            foreach ($reflection->getProperties() as $property) {
                $value = $request->get($property->getName());
                $method = 'set' . ucfirst($property->getName());

                if (!$reflection->hasMethod($method) || $value === null) {
                    continue;
                }

                $type = array_shift($reflection->getMethod($method)->getParameters())->getType()->getName();
                $typeSet = settype($value, $type);

                if (!$typeSet) {
                    continue;
                }

                $dto->{$method}($value);
                $request->attributes->remove($property->getName());
            }

            $request->attributes->set($configuration->getName(), $dto);
        } catch (\Exception $e) {
            $this->logger->notice(__CLASS__ . ': ' . $e->getMessage());
        } catch (\Error $e) {
            $this->logger->warning(__CLASS__ . ': ' . $e->getMessage());
        }

        return $configuration->isOptional() || !empty($dto);
    }

    /**
     * Checks if the object is supported.
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return true;
    }
}