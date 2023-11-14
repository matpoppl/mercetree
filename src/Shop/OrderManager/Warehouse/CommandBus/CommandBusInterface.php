<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\CommandBus;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler\HandlerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

interface CommandBusInterface
{
    /**
     * @param class-string<CommandInterface> $commandClassName
     * @param class-string<HandlerInterface> $handlerClassName
     */
    public function subscribe(string $commandClassName, string $handlerClassName) : void;

    /**
     * @throws CommandExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function dispatch(CommandInterface $command) : void;
}
