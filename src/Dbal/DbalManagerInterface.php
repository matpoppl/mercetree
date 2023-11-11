<?php

namespace Mateusz\Mercetree\Dbal;

use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\AdapterInterface;

interface DbalManagerInterface
{
    public function get(string $id) : AdapterInterface;
}
