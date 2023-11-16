<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseRepositoryInterface;

class RepositoryCloseCommand implements CommandInterface
{
    /**
     * @template T of WarehouseRepositoryInterface
     * @param class-string<T> $items
     * @param RepositoryCloseEnum $items
     */
    public function __construct(private readonly string $repository, private readonly RepositoryCloseEnum $closeType)
    {
    }
    
    /**
     * @return RepositoryCloseEnum
     */
    public function getCloseType() : RepositoryCloseEnum
    {
        return $this->closeType;
    }
    
    /**
     * @return WarehouseRepositoryInterface
     */
    public function getRepository() : string
    {
        return $this->repository;
    }
}
