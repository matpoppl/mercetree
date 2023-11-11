<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Validator;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessageInterface;

class TreeValidatorResult implements TreeValidatorResultInterface
{
    public function __construct(private readonly array $treeErrors, private readonly array $rowsErrors)
    {
    }

    /**
     * @return ErrorMessageInterface[]
     */
    public function getTreeErrors(): array
    {
        return $this->treeErrors;
    }

    public function getRowIds(): array
    {
        return array_keys($this->rowsErrors);
    }

    /**
     * @param string $rowId
     * @return ErrorMessageInterface[]
     */
    public function getRowErrors(string $rowId): array
    {
        return $this->rowsErrors[$rowId] ?? [];
    }

    public function isValid() : bool
    {
        return empty($this->treeErrors) && empty($this->rowsErrors);
    }
}
