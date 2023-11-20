<?php

namespace Mateusz\Mercetree\Event;

use Throwable;

abstract class AbstractStoppableEvent implements StoppableEventInterface
{
    private ?Throwable $stopReason = null;
    
    public function stopPropagation(Throwable $stopReason) : void
    {
        $this->stopReason = $stopReason;
    }
    
    public function getStopReason() : ?Throwable
    {
        return $this->stopReason;
    }
    
    public function isPropagationStopped() : bool
    {
        return null !== $this->stopReason;
    }
}
