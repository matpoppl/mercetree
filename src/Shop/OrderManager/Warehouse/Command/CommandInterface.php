<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

interface CommandInterface
{
    public function execute() : bool;
}
