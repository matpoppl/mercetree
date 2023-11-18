<?php

namespace Mateusz\Mercetree\Event;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Psr\Log\LoggerInterface;

class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(private readonly ListenerProviderInterface $listenerProvider, private readonly LoggerInterface $logger)
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
        $return = $listener($event);

        $eventsToEmmit = [];

        if ($return instanceof EmittedEventInterface) {
            $eventsToEmmit[] = $return;
        } else if (is_iterable($return)) {
            foreach ($return as $possibleEvent) {
                if ($possibleEvent instanceof EmittedEventInterface) {
                    $eventsToEmmit[] = $possibleEvent;
                }
            }
        }

        foreach ($eventsToEmmit as $eventToEmmit) {

            if ($event === $eventToEmmit) {
                $this->logger->error("Possible infinite event dispatch loop detected", [
                    'exception' => new DispatchedDispatchedEventException($eventToEmmit, "Possible infinite event dispatch loop detected"),
                ]);
                continue;
            }

            $this->dispatch($eventToEmmit);
        }
    }
}
