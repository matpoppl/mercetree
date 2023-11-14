<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandInterface;

interface HandlerInterface
{
    /**
     * @throws CommandExceptionInterface
     */
    public function __invoke(CommandInterface $command) : void;
}
