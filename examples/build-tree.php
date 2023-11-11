<?php

namespace Mateusz\Mercetree\TreeConfigurator;

use Mateusz\Mercetree\ProductConfigurator\Feature\SlotCollection;
use Mateusz\Mercetree\TreeConfigurator\Feature\Bauble;
use Mateusz\Mercetree\TreeConfigurator\Feature\Color;
use Mateusz\Mercetree\TreeConfigurator\Feature\SizeSymbol;

$tree = new Item\Tree();

$tree->addRow(
    new TreeRow('row0', SlotCollection::create('row')
    ->add( new Bauble(new SizeSymbol('small'), new Color('red')) )
    )
);

$tree->addRow(
    new TreeRow('row1', SlotCollection::create('row')
    ->add( new Bauble(new SizeSymbol('small'), new Color('green')) )
    ->add( new Bauble(new SizeSymbol('small'), new Color('yellow')) )
    )
);

$tree->addRow(
    new TreeRow('row2', SlotCollection::create('row')
    ->add( new Bauble(new SizeSymbol('small'), new Color('green')) )
    ->add( new Bauble(new SizeSymbol('small'), new Color('red')) )
    ->add( new Bauble(new SizeSymbol('small'), new Color('yellow')) )
    )
);

$tree->addRow(
    new TreeRow('row3', SlotCollection::create('row')
    ->add( new Bauble(new SizeSymbol('small'), new Color('yellow')) )
    ->add( new Bauble(new SizeSymbol('small'), new Color('orange')) )
    ->add( new Bauble(new SizeSymbol('small'), new Color('green')) )
    ->add( new Bauble(new SizeSymbol('small'), new Color('red')) )
    )
);

return $tree;
