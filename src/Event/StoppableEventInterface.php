<?php

namespace Mateusz\Mercetree\Event;

use Psr\EventDispatcher\StoppableEventInterface as BaseEvent;
use Throwable;

interface StoppableEventInterface extends BaseEvent
{
    public function stopPropagation(Throwable $stopReason) : void;
    public function getStopReason() : ?Throwable;
}
