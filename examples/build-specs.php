<?php

use Mateusz\Mercetree\TreeConfigurator\Specification\TreeRowSpecification;
use Mateusz\Mercetree\TreeConfigurator\Specification\TreeSpecification;
use Mateusz\Mercetree\TreeConfigurator\Constraint\SlotCollectionSize;
use Mateusz\Mercetree\ProductConfigurator\Feature\SlotCollection;

/*
tree
- rows: 4,5,6
*/

/*
$validSizes = ['male-bombki', 'srednie-bombki'];

$tree->addSpecification(new TreeRowsSpecification([
    'constraints' => [
        new SlotCollectionSize(['min' => 4, 'max' => 4]),
        new RowsDecorationSize(['allowed' => $validSizes]),
        new RowsRowNoRepeat(),
        new RowsAllowedDecorators(['bombki-*']),
        new RowSpecificDecorators([
            'row0' => new RowSpecification([
                new SlotCollectionSize(['min' => 1, 'max' => 1]),
            ]),
            'row1' => new RowSpecification([
                new SlotCollectionSize(['min' => 2, 'max' => 2]),
            ]),
            'row2' => new RowSpecification([
                new SlotCollectionSize(['min' => 3, 'max' => 3]),
            ]),
            'row3' => new RowSpecification([
                new SlotCollectionSize(['min' => 4, 'max' => 4]),
            ]),
        ]),
    ],
]));
*/

$tree = new TreeSpecification();

$tree->addRow(new TreeRowSpecification('row0'));
$tree->addRow(new TreeRowSpecification('row1'));
$tree->addRow(new TreeRowSpecification('row2'));
$tree->addRow(new TreeRowSpecification('row3'));

return $tree;
