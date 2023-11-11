<?php

use Mateusz\Mercetree\TreeConfigurator\Builder\TreeBuilder;
use Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator;
use Mateusz\Mercetree\TreeConfigurator\Feature\Bauble;
use Mateusz\Mercetree\ProductConfigurator\Feature\SizeSymbolInterface;

$builder = new TreeBuilder();

$posi = ['bauble-size-small-color-orange', 'bauble-size-small-color-red', 'bauble-size-small-color-green', 'bauble-size-small-color-purple'];
$posi = ['bauble-size-small-color-orange', 'bauble-size-small-color-red'];
$posi = ['bauble-size-small-color-red', 'bauble-size-small-color-green', 'bauble-size-medium-color-orange', 'bauble-size-small-color-yellow', 'bauble-size-medium-color-orange', 'bauble-size-medium-color-blue'];

$builder
    ->addConstraint( new Constraint\RowCount(min: 1, max: 1) )
    ->addConstraint( new Constraint\UnusedPossibilities([4], $posi) )

    ->addRow('row0')
    ->addConstraint( new Constraint\RowFeatureCount(min: 4, max: 4) )
    ->addConstraint( new Constraint\FeatureRepeatLimit(max: 1) )
    ->addConstraint( new Constraint\OnlyNestedFeatureSymbols(nestedFeatureType: SizeSymbolInterface::class,  allowedSymbols: ['size-small', 'size-medium']) )
    ->tree();

$tree = $builder->buildTree();

$tree->getRow('row0')
    ->add( Bauble::create(size: 'small', color: 'red') )
    ->add( Bauble::create(size: 'small', color: 'green') )
    ->add( Bauble::create(size: 'medium', color: 'orange') )
    ->add( Bauble::create(size: 'medium', color: 'blue') );

// @TODO na danym rozmiarze drzewka muszą być użyte wszystkie ozdoby dostępne dla tego rozmiaru

$validation = new Validator\TreeValidator();

$errors = $validation->validate($tree);

print_r($errors);

return $tree;
