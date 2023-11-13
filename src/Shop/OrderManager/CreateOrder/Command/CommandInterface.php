<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command;

interface CommandInterface
{
    public function execute() : bool;
}
