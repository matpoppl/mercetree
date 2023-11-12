<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\Structure;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTreeInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowsInterface;

class Structure implements StructureInterface
{
    public function __construct(private readonly BuiltTreeInterface $builtTree)
    {}

    public function getRowsCount() : int
    {
        return iterator_count( $this->builtTree->getRows() );
    }

    public function getRows() : RowsInterface
    {
        return $this->builtTree->getRows();
    }
}
