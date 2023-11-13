<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command;

abstract class AbstractTransactionCommand implements CommandInterface, CommandWithExceptionsInterface
{
    /**
     * @var \Throwable[]
     */
    protected array $exceptions = [];

    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
