<?php

namespace Mateusz\Mercetree\EntityManager\Repository;

interface RepositoryManagerInterface
{
    public function get(string $entityType): RepositoryInterface;
}
