<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CommandBus;

interface CommandExceptionInterface extends \Throwable
{
    public function getCommand() : CommandInterface;
}
