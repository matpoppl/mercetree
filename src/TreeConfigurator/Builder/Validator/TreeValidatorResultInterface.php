<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Validator;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessageInterface;

interface TreeValidatorResultInterface
{
    /**
     * @return ErrorMessageInterface[]
     */
    public function getTreeErrors(): array;

    /**
     * @return string[]
     */
    public function getRowIds(): array;

    /**
     * @param string $rowId
     * @return ErrorMessageInterface[]
     */
    public function getRowErrors(string $rowId): array;

    public function isValid() : bool;
}
