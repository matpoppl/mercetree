<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

interface CommandExceptionInterface extends \Throwable
{
    public function getCommand() : CommandInterface;
}
