<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal;

use Traversable;
use Countable;

/**
 * @template T
 * @extends Traversable<T>
 */
interface StatementInterface extends Traversable, Countable
{
    public function execute(array $params = null) : bool;
}
