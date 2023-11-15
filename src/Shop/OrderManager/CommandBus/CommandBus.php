<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CommandBus;

use Psr\Container\ContainerInterface;

class CommandBus implements CommandBusInterface
{
    /**
     * @var array<string, string[]>
     */
    private array $subscriptions = [];

    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function subscribe(string $commandClassName, string $handlerClassName) : void
    {
        $this->subscriptions[$commandClassName][] = $handlerClassName;
    }

    public function dispatch(CommandInterface $command) : void
    {
        $commandClassName = get_class($command);

        $handlers = $this->subscriptions[$commandClassName] ?? [];

        foreach ($handlers as $id) {
            $handler = $this->container->get($id);
            $handler($command);
        }
    }
}
