<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrder;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseManagerInterface;

class TransactionProcessCommand extends AbstractTransactionCommand
{
    private ?OrderEntityInterface $entity;

    /**
     * @var OrderItemEntityInterface[]
     */
    private array $items;

    public function __construct(private readonly CreateOrderManagerInterface $createOrderManager, private readonly WarehouseManagerInterface $warehouseManager, private readonly OrderRequestInterface $request)
    {
    }

    public function execute() : bool
    {
        $this->entity = null;
        $this->items = [];
        $this->exceptions = [];

        try {
            if (! $this->warehouseManager->decreaseStock($this->request->getItems())) {
                return false;
            }
        } catch (WarehouseExceptionInterface $e) {
            $this->exceptions[] = $e;
            return false;
        }

        try {
            $this->entity = $this->createOrderManager->createOrder($this->request);

            if (! $this->entity) {
                return false;
            }

            $this->items = $this->createOrderManager->createOrderItems($this->entity, $this->request);

            if (count($this->request->getItems()) === count($this->items)) {
                $this->exceptions[] = new \UnexpectedValueException('Unexpected item count mismatch');
                return false;
            }

        } catch (CreateOrderExceptionInterface $e) {
            $this->exceptions[] = $e;
        }

        return empty($this->exceptions);
    }

    public function getCreatedOrder() : ?CreatedOrderInterface
    {
        if ($this->entity && $this->items) {
            return new CreatedOrder($this->entity, $this->items);
        }

        return null;
    }
}
