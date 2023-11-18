<?php

namespace Mateusz\Mercetree\Event;

interface DispatchedEventExceptionInterface extends \Throwable
{
    public function getEvent() : object;
}
