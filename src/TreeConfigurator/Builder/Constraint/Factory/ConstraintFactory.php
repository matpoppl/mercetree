<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;

class ConstraintFactory implements FactoryInterface
{
    /**
     * @template T of ConstraintInterface
     * @param ContainerInterface $container
     * @param class-string<T> $requestedName
     * @param array|null $options
     * @return ConstraintInterface
     * @throws FactoryException
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        try {
            $ref = new ReflectionClass($requestedName);
        } catch (ReflectionException) {
            throw FactoryException::classDontExists($requestedName);
        }

        $args = [];

        foreach ($ref->getConstructor()->getParameters() as $param) {
            $argName = $param->getName();
            $argVal = $options[ $argName ] ?? null;

            if (null === $argVal && ! $param->allowsNull()) {
                throw FactoryException::missingParameter($requestedName, $argName);
            }

            $args[ $argName ] = $argVal;
        }

        return new $requestedName(...$args);
    }
}
