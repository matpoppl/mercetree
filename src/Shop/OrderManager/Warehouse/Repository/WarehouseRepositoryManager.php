<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Psr\Container\ContainerInterface;

class WarehouseRepositoryManager implements WarehouseRepositoryManagerInterface
{
    public function __construct(private readonly ContainerInterface $repositoryManager)
    {
    }
    
    public function get(string $id) : WarehouseRepositoryInterface
    {
        return $this->repositoryManager->get($id);
    }
}
