<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\HandlerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\RepositoryBeginCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseRepositoryManagerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\RepositoryExceptionInterface;

class RepositoryBeginHandler implements HandlerInterface
{
    public function __construct(private readonly WarehouseRepositoryManagerInterface $repositories)
    {
    }

    public function __invoke(CommandInterface $command) : void
    {
        if (! $command instanceof RepositoryBeginCommand) {
            throw new CommandException($command,"Unsupported command type");
        }
        
        try {
            $repository = $this->repositories->get( $command->getRepository() );
        } catch (NotFoundExceptionInterface $e) {
            throw new CommandException($command, "Repository `{$command->getRepository()}` not found", 0 , $e);
        }
        
        try {
            $ok = $repository->begin($command->getStockItems());
            $exception = null;
        } catch (RepositoryExceptionInterface $exception) {
            $ok = false;
        }
        
        if (! $ok) {
            throw new CommandException($command, "Repository begin error", 0, $exception);
        }
    }
}
