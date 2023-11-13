<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command;

interface CommandWithExceptionsInterface
{
    /**
     * @return  \Throwable[]
     */
    public function getExceptions(): array;
}
