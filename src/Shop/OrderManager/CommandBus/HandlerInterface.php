<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CommandBus;

interface HandlerInterface
{
    /**
     * @throws CommandExceptionInterface
     */
    public function __invoke(CommandInterface $command) : void;
}
