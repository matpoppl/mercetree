<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Validator;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTreeInterface;

interface TreeValidatorInterface
{
    public function validate(BuiltTreeInterface $tree) : TreeValidatorResultInterface;
}
