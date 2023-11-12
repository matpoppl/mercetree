<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

interface BuiltTreeInterface
{
    /**
     * @throws RowExceptionInterface
     */
    public function getRow(string $rowId) : RowInterface;

    public function getRows() : RowsInterface;
}
