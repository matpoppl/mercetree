<?php

namespace Mateusz\Mercetree\Event;

use Psr\EventDispatcher\ListenerProviderInterface as PsrListenerProvider;

interface ListenerProviderInterface extends PsrListenerProvider
{
    /**
     * @param string $eventType
     * @param class-string|callable $listener
     * @throws ListenerProviderExceptionInterface
     * @return void
     */
    public function on(string $eventType, string|callable $listener) : void;

}
