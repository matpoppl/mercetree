<?php

use Mateusz\Mercetree\TreeConfigurator\TreeConfiguratorComponentInterface;
use Mateusz\Mercetree\TreeConfigurator\Feature\Bauble;

/** @var TreeConfiguratorComponentInterface $component */

$builtTree = $component->getBuiltTreeProvider()->get('tree:small');

//$configurator = require __DIR__ . '/../examples/build-tree.php';
//$configurator = require __DIR__ . '/../examples/build-specs.php';
//$configurator = require __DIR__ . '/../examples/dbal.php';
//$configurator = require __DIR__ . '/../examples/data.php';
//$configurator = require __DIR__ . '/../examples/rules.php';

$builtTree->getRow('row0')
    ->add( Bauble::create(size: 'small', color: 'red') )
    ->add( Bauble::create(size: 'small', color: 'blue') )
    ->add( Bauble::create(size: 'small', color: 'yellow') )
    ->add( Bauble::create(size: 'medium', color: 'green') );

$builtTree->getRow('row1')
    ->add( Bauble::create(size: 'medium', color: 'white') )
    ->add( Bauble::create(size: 'medium', color: 'pink') )
    ->add( Bauble::create(size: 'small', color: 'yellow') );

$builtTree->getRow('row2')
    ->add( Bauble::create(size: 'medium', color: 'green') )
    ->add( Bauble::create(size: 'small', color: 'yellow') );

$builtTree->getRow('row3')
    ->add( Bauble::create(size: 'medium', color: 'pink') );

$validationResults = $component->getTreeValidator()->validate($builtTree);
