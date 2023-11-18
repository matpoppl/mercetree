<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\ReadRepository;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderEventInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderStepEnum;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;

class CreateOrderListener
{
    public function __construct(private readonly WarehouseReadRepositoryInterface $repository)
    {
    }

    public function __invoke(object $event) : void
    {
        if (! $event instanceof CreateOrderEventInterface) {
            return;
        }

        try {
            $ok = match ($event->getCurrentStep()) {
                CreateOrderStepEnum::BEGIN => $this->repository->transactionBegin(),
                CreateOrderStepEnum::COMMIT => true,
                CreateOrderStepEnum::ROLLBACK => $this->repository->transactionRollback(),
            };
            $exception = null;
        } catch (RepositoryExceptionInterface $exception) {
            $ok = false;
        }

        if ($ok) {
            return;
        }

        $exception ??= new \UnexpectedValueException('Repository exception expected at failure');

        $event->stopPropagation($exception);
    }
}
