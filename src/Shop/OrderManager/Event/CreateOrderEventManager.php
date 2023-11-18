<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Event;

use Mateusz\Mercetree\Event\ListenerProviderInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class CreateOrderEventManager implements CreateOrderEventManagerInterface
{
    public function __construct(private readonly ListenerProviderInterface $listenerProvider, private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    public function on(string $eventType, string|callable $listener) : void
    {
        $this->listenerProvider->on($eventType, $listener);
    }

    public function dispatch(object $event)
    {
        $this->eventDispatcher->dispatch($event);
    }
}
