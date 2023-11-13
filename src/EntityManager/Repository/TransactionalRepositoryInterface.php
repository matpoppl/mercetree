<?php

namespace Mateusz\Mercetree\EntityManager\Repository;

interface TransactionalRepositoryInterface
{
    /**
     * @throws RepositoryExceptionInterface
     */
    public function transactionBegin(): bool;

    /**
     * @throws RepositoryExceptionInterface
     */
    public function transactionRollback(): bool;

    /**
     * @throws RepositoryExceptionInterface
     */
    public function transactionCommit(): bool;
}
