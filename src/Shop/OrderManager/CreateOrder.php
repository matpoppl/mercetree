<?php

namespace Mateusz\Mercetree\Shop\OrderManager;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderEventInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderEventManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

class CreateOrder implements CreateOrderInterface
{
    public function __construct(private readonly CreateOrderEventManagerInterface $eventManager)
    {}

    /**
     * @throws OrderManagerExceptionInterface
     */
    public function create(OrderRequestInterface $request) : ?CreatedOrderInterface
    {
        try {
            $this->dispatch(new Event\CreateOrderEvent(Event\CreateOrderStepEnum::BEGIN, $request), "CreateOrder begin error");
            $createdOrder = $this->process($request);
        } catch (OrderManagerExceptionInterface $beginException) {
            $this->dispatch(new Event\CreateOrderEvent(Event\CreateOrderStepEnum::ROLLBACK, $request), "CreateOrder rollback error");
            // BEGIN or ROLLBACK line before
            throw $beginException;
        }

        try {
            $this->dispatch(new Event\CreateOrderEvent(Event\CreateOrderStepEnum::COMMIT, $request), "CreateOrder commit error");
            // @TODO emmit OrderCreatedEvent($createdOrder)
            return $createdOrder;
        } catch (OrderManagerExceptionInterface $closeException) {
        }

        try {
            $this->dispatch(new Event\CreateOrderEvent(Event\CreateOrderStepEnum::ROLLBACK, $request), "CreateOrder rollback error");
        } catch (OrderManagerExceptionInterface $closeException) {
        }

        // COMMIT or ROLLBACK
        throw $closeException;
    }

    /**
     * @throws OrderManagerExceptionInterface
     */
    private function dispatch(CreateOrderEventInterface $event, string $exceptionMessage) : CreateOrderEventInterface
    {
        $this->eventManager->dispatch($event);

        if ($exitReason = $event->getStopReason()) {
            throw new OrderManagerException($exceptionMessage, 0, $exitReason);
        }

        return $event;
    }

    /**
     * @throws OrderManagerExceptionInterface
     */
    public function process(OrderRequestInterface $request) : CreatedOrderInterface
    {
        $processEvent = $this->dispatch(new Event\CreateOrderProcessEvent(Event\CreateOrderStepEnum::COMMIT, $request), "CreateOrder process error");

        if (! $processEvent instanceof Event\CreateOrderProcessEventInterface) {
            throw new OrderManagerException("Unsupported dispatched process event type");
        }

        $createdOrder = $processEvent->getProcessedData(CreatedOrderInterface::class);

        if ($createdOrder instanceof CreatedOrderInterface) {
            return $createdOrder;
        }

        throw new OrderManagerException('CreateOrder process CreatedOrder missing');
    }
}
