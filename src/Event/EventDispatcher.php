<?php

namespace Mateusz\Mercetree\Event;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class EventDispatcher implements EventDispatcherInterface
{
    private array $queue = [];

    public function __construct(private readonly ListenerProviderInterface $listenerProvider)
    {
    }

    public function dispatch(object $event) : object
    {
        if ($event instanceof StoppableEventInterface) {

            foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {

                if ($event->isPropagationStopped()) {
                    break;
                }

                $this->_dispatch($event, $listener);
            }
        } else {
            foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
                $this->_dispatch($event, $listener);
            }
        }

        return $event;
    }

    public function _dispatch(object $event, callable $listener) : void
    {
        $this->queue[] = $event;

        while ($currentEvent = array_shift($this->queue)) {
            $listener($currentEvent);
        }
    }
}
