<?php

namespace Mateusz\Mercetree\Shop\OrderManager;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command\CommandWithExceptionsInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command\TransactionProcessCommand;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command\TransactionsBeginCommand;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command\TransactionsCommitCommand;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command\TransactionsRollbackCommand;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseManagerInterface;

class CreateOrder implements CreateOrderInterface
{
    public function __construct(private readonly WarehouseManagerInterface $warehouseManager, private readonly CreateOrderManagerInterface $createOrderManager)
    {
    }

    /**
     * @throws OrderManagerExceptionInterface
     */
    public function begin(OrderRequestInterface $request) : bool
    {
        return $this->runCommand(new TransactionsBeginCommand($this->createOrderManager, $this->warehouseManager, $request->getItems()));
    }

    /**
     * @throws OrderManagerExceptionInterface
     */
    public function commit() : bool
    {
        return $this->runCommand(new TransactionsCommitCommand($this->createOrderManager, $this->warehouseManager));
    }

    /**
     * @throws OrderManagerExceptionInterface
     */
    public function rollback(OrderRequestInterface $request) : void
    {
        $this->runCommand(new TransactionsRollbackCommand($this->createOrderManager, $this->warehouseManager, $request->getItems()));
    }

    /**
     * @throws OrderManagerExceptionInterface
     */
    public function runCommand(CommandInterface $cmd) : bool
    {
        if ($cmd->execute()) {
            return true;
        }

        if (! $cmd instanceof CommandWithExceptionsInterface) {
            return false;
        }

        foreach ($cmd->getExceptions() as $exception) {
            throw new OrderManagerException("Command exception", 0, $exception);
        }

        return false;
    }

    /**
     * @throws OrderManagerExceptionInterface
     */
    public function create(OrderRequestInterface $request) : ?CreatedOrderInterface
    {
        try {
            return $this->_create($request);
        } catch (OrderManagerExceptionInterface $exception) {
        }

        $this->rollback($request);

        throw $exception;
    }

    /**
     * @throws OrderManagerExceptionInterface
     */
    public function _create(OrderRequestInterface $request) : ?CreatedOrderInterface
    {
        if (! $this->begin($request)) {
            $this->rollback($request);
            throw new OrderManagerException("CreateOrder begin exception");
        }

        $process = new TransactionProcessCommand($this->createOrderManager, $this->warehouseManager, $request);

        if (! $this->runCommand($process)) {
            $this->rollback($request);
            return null;
        }

        $createdOrder = $process->getCreatedOrder();

        if (! $createdOrder) {
            $this->rollback($request);
            return null;
        }

        if (! $this->commit()) {
            $this->rollback($request);
            return null;
        }

        return $createdOrder;
    }
}
