<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;

class WarehouseException extends \Exception implements WarehouseExceptionInterface
{
    public static function commandException(CommandInterface $command, string $msg) : static
    {
        return new static($msg, 0, new CommandException($command, $msg));
    }
}
