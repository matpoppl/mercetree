<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

use Mateusz\Mercetree\Shop\Product\View\ProductInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\ProductInterface as EntityProductInterface;

class Product implements ProductInterface
{
    public function __construct(private readonly EntityProductInterface $entity, private readonly int $quantity)
    {
    }

    public function getName(): string
    {
        return $this->entity->getName();
    }

    public function getBasePriceNet(): float
    {
        return $this->entity->getPrice();
    }

    public function getTaxRate(): int
    {
        return $this->entity->getTaxRate();
    }

    public function getCurrencySymbol(): string
    {
        return $this->entity->getCurrencySymbol();
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
