<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Data;

use Psr\Container\ContainerInterface;

use function class_exists;
use function is_subclass_of;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;

class MockRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): mixed
    {
        if (! class_exists($requestedName)) {
            $requestedName = MockRepository::class;
        }

        if (null === $options) {
            $options = $container->get(ConfigInterface::class)->getArray($requestedName);
        }

        if (null !== $options && !is_array($options)) {
            throw new \UnexpectedValueException('Unsupported options type');
        }

        if (! is_subclass_of($requestedName, RepositoryInterface::class)) {
            throw new \UnexpectedValueException("Unsupported repository type `{$requestedName}`");
        }

        return new $requestedName($options);
    }
}
