<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\HandlerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseRepositoryManagerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\RepositoryCloseCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\RepositoryCloseEnum;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\RepositoryExceptionInterface;

class RepositoryCloseHandler implements HandlerInterface
{
    public function __construct(private readonly WarehouseRepositoryManagerInterface $repositories)
    {
    }

    public function __invoke(CommandInterface $command) : void
    {
        if (! $command instanceof RepositoryCloseCommand) {
            throw new CommandException($command,"Unsupported command type");
        }
        
        try {
            $repository = $this->repositories->get( $command->getRepository() );
            $exception = null;
        } catch (RepositoryExceptionInterface $exception) {
            $repository = null;
        } catch (NotFoundExceptionInterface $exception) {
            $repository = null;
        }
        
        if (! $repository) {
            throw new CommandException($command, "Repository `{$command->getRepository()}` not found", 0 , $exception);
        }
        
        $ok = match ($command->getCloseType()) {
            RepositoryCloseEnum::ROLLBACK => $repository->rollback(),
            RepositoryCloseEnum::COMMIT => $repository->commit(),
            default => throw new CommandException($command, "Unsupported repository close type"),
        };
        
        if (! $ok) {
            throw new CommandException($command, "Repository close error");
        }
    }
}
