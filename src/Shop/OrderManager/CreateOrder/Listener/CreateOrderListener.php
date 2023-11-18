<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Listener;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderEventInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderStepEnum;

class CreateOrderListener
{
    public function __construct(private readonly CreateOrderManagerInterface $manager)
    {
    }

    public function __invoke(object $event) : void
    {
        if (! $event instanceof CreateOrderEventInterface) {
            return;
        }

        try {
            $ok = match ($event->getCurrentStep()) {
                CreateOrderStepEnum::BEGIN => $this->manager->transactionBegin(),
                CreateOrderStepEnum::COMMIT => true,
                CreateOrderStepEnum::ROLLBACK => $this->manager->transactionRollback(),
            };
            $exception = null;
        } catch (CreateOrderExceptionInterface $exception) {
            $ok = false;
        }

        if ($ok) {
            return;
        }

        $exception ??= new \UnexpectedValueException('Repository exception expected at failure');

        $event->stopPropagation($exception);
    }
}
