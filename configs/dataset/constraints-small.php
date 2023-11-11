<?php

use Mateusz\Mercetree\Application\Component\ComponentManagerInterface;
use Mateusz\Mercetree\ProductConfigurator\Feature\SizeSymbolInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\PossibilitiesBuilderInterface;
use Mateusz\Mercetree\TreeConfigurator\TreeConfiguratorComponentInterface;
use Psr\Container\ContainerInterface;

/** @global $container */
/** @var ContainerInterface $container Provided by the config file loader */
/** @var TreeConfiguratorComponentInterface $configurator */
/** @var PossibilitiesBuilderInterface $possibilities */

$configurator = $container->get(ComponentManagerInterface::class)->get(TreeConfiguratorComponentInterface::class);

$possibilities = $configurator->getPossibilitiesBuilder()->getBySize('small');

// Flat records, emulate db rows

$tree = [
    [
        'product_id' => 'tree:small',
        'slot_name' => null,
        /** @see \Mateusz\Mercetree\TreeConfigurator\Data\Entity\ConstraintEntity */
        'constraint_type' => Constraint\RowCount::class,
        'constraint_args' => ['min' => 4, 'max' => 4]
    ], [
        'product_id' => 'tree:small',
        'slot_name' => null,
        'constraint_type' => Constraint\UnusedPossibilities::class,
        'constraint_args' => ['rowCounts' => [4, 3, 2, 1], 'symbols' => $possibilities]
    ], [
        'product_id' => 'tree:small',
        'slot_name' => null,
        'constraint_type' => Constraint\UnknownPossibilities::class,
        'constraint_args' => ['symbols' => $possibilities]
    ]
];

$row0 = [
    [
        'product_id' => 'tree:small',
        'slot_name' => 'row0',
        'constraint_type' => Constraint\RowFeatureCount::class,
        'constraint_args' => ['min' => 4, 'max' => 4]
    ], [
        'product_id' => 'tree:small',
        'slot_name' => 'row0',
        'constraint_type' => Constraint\FeatureRepeatLimit::class,
        'constraint_args' => ['max' => 1]
    ], [
        'product_id' => 'tree:small',
        'slot_name' => 'row0',
        'constraint_type' => Constraint\OnlyNestedFeatureSymbols::class,
        'constraint_args' => ['nestedFeatureType' => SizeSymbolInterface::class, 'allowedSymbols' => ['size:small', 'size:medium']]
    ]
];

$row1 = [
    [
        'product_id' => 'tree:small',
        'slot_name' => 'row1',
        'constraint_type' => Constraint\RowFeatureCount::class,
        'constraint_args' => ['min' => 3, 'max' => 3]
    ], [
        'product_id' => 'tree:small',
        'slot_name' => 'row1',
        'constraint_type' => Constraint\FeatureRepeatLimit::class,
        'constraint_args' => ['max' => 1]
    ], [
        'product_id' => 'tree:small',
        'slot_name' => 'row1',
        'constraint_type' => Constraint\OnlyNestedFeatureSymbols::class,
        'constraint_args' => ['nestedFeatureType' => SizeSymbolInterface::class, 'allowedSymbols' => ['size:small', 'size:medium']]
    ]
];

$row2 = [
    [
        'product_id' => 'tree:small',
        'slot_name' => 'row2',
        'constraint_type' => Constraint\RowFeatureCount::class,
        'constraint_args' => ['min' => 2, 'max' => 2]
    ], [
        'product_id' => 'tree:small',
        'slot_name' => 'row2',
        'constraint_type' => Constraint\FeatureRepeatLimit::class,
        'constraint_args' => ['max' => 1]
    ], [
        'product_id' => 'tree:small',
        'slot_name' => 'row2',
        'constraint_type' => Constraint\OnlyNestedFeatureSymbols::class,
        'constraint_args' => ['nestedFeatureType' => SizeSymbolInterface::class, 'allowedSymbols' => ['size:small', 'size:medium']]
    ]
];

$row3 = [
    [
        'product_id' => 'tree:small',
        'slot_name' => 'row3',
        'constraint_type' => Constraint\RowFeatureCount::class,
        'constraint_args' => ['min' => 1, 'max' => 1]
    ], [
        'product_id' => 'tree:small',
        'slot_name' => 'row3',
        'constraint_type' => Constraint\FeatureRepeatLimit::class,
        'constraint_args' => ['max' => 1]
    ], [
        'product_id' => 'tree:small',
        'slot_name' => 'row3',
        'constraint_type' => Constraint\OnlyNestedFeatureSymbols::class,
        'constraint_args' => ['nestedFeatureType' => SizeSymbolInterface::class, 'allowedSymbols' => ['size:small', 'size:medium']]
    ]
];

return array_merge($tree, $row0, $row1, $row2, $row3);
