<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

use Exception;
use Throwable;

class CommandException extends Exception implements CommandExceptionInterface
{
    public function __construct(private readonly CommandInterface $command, string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return CommandInterface
     */
    public function getCommand(): CommandInterface
    {
        return $this->command;
    }
}
