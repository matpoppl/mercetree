<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Event;

use Mateusz\Mercetree\Event\ListenerProviderExceptionInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

interface CreateOrderEventManagerInterface extends EventDispatcherInterface
{
    /**
     * @param string $eventType
     * @param class-string|callable $listener
     * @throws ListenerProviderExceptionInterface
     * @return void
     */
    public function on(string $eventType, string|callable $listener) : void;
}
