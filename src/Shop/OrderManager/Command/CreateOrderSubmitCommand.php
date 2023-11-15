<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Command;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrder;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

class CreateOrderSubmitCommand implements CommandInterface
{
    private ?OrderEntityInterface $entity;

    /**
     * @var OrderItemEntityInterface[]
     */
    private array $items;

    public function __construct(private readonly OrderRequestInterface $request)
    {
    }

    public function getOrderRequest() : OrderRequestInterface
    {
        return $this->request;
    }

    public function setOrderEntity(OrderEntityInterface $entity)
    {
        $this->entity = $entity;
    }

    public function setOrderItemEntities(array $items)
    {
        $this->items = $items;
    }

    public function getCreatedOrder() : ?CreatedOrderInterface
    {
        if ($this->entity && $this->items) {
            return new CreatedOrder($this->entity, $this->items);
        }

        return null;
    }
}
