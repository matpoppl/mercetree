<?php

namespace Mateusz\Mercetree\Event;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;

class ListenerProvider implements ListenerProviderInterface
{
    /**
     * @var class-string[]
     */
    private array $listeners = [];

    public function __construct(private readonly ContainerInterface $container, private readonly LoggerInterface $logger)
    {
    }

    public function on(string $eventType, string|callable $listener) : void
    {
        if (! array_key_exists($eventType, $this->listeners)) {
            $this->listeners[$eventType] = [];
        }

        if (is_string($listener) && ! $this->container->has($listener)) {
            throw new ListenerProviderException("Listener `{$listener}` not found in listener container");
        }

        $this->listeners[$eventType][] = $listener;
    }

    public function getListenersForEvent(object $event): iterable
    {
        $eventTypes = [get_class($event)];

        try {
            $reflection = new ReflectionClass($event);
            foreach ($reflection->getInterfaceNames() as $eventType) {
                $eventTypes[] = $eventType;
            }
        } catch (ReflectionException $ex) {
            $this->logger->debug('Event reflection error', [
                'exception' => $ex
            ]);
        }

        $listeners = [];

        foreach ($eventTypes as $eventType) {
            $listeners[] = $this->listeners[$eventType] ?? [];
        }

        $listeners = array_merge(...$listeners);

        foreach ($listeners as $key => $listener) {
            if (is_string($listener)) {
                try {
                    $listenerCallable = $this->container->get($listener);
                } catch (NotFoundExceptionInterface|ContainerExceptionInterface $exception) {
                    $this->logger->critical("Listener `{$listener}` container error", [
                        'exception' => $exception,
                    ]);
                    continue;
                }

                if (! is_callable($listenerCallable)) {
                    $this->logger->critical("Listener is not callable", [
                        'exception' => new \UnexpectedValueException("Listener `{$listener}` is not callable"),
                    ]);
                    continue;
                }

                $listeners[$key] = $listenerCallable;
            }
        }

        return $listeners;
    }
}
