<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Data;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class PresenterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if (! class_exists($requestedName)) {
            $requestedName = Presenter::class;
        }

        $repository = $container->get(RepositoryInterface::class);
        $cache = $container->get('cache.fast');

        return new $requestedName($repository, $cache);
    }
}
