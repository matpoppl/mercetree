<?php

namespace Mateusz\Mercetree\Shop\OrderManager;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderEventManagerInterface;
use Psr\Container\ContainerInterface;

class CreateOrderFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);

        $listeners = $options['listeners'] ?? [];

        $evtMgr = $container->get(CreateOrderEventManagerInterface::class);

        foreach ($listeners as $listenerData) {
            [$evtType, $listener] = $listenerData;
            $evtMgr->on($evtType, $listener);
        }

        return new $requestedName($evtMgr);
    }
}
