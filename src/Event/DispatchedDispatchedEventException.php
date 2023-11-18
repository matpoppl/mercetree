<?php

namespace Mateusz\Mercetree\Event;

use \Throwable;

class DispatchedDispatchedEventException extends \Exception implements DispatchedEventExceptionInterface
{
    public function __construct(private readonly object $event, string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getEvent() : object
    {
        return $this->event;
    }
}
