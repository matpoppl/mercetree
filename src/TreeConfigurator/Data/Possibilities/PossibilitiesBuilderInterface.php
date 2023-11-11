<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Possibilities;

use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule\InvalidEntityException;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule\RuleMatcherInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule\TreeDecorationRuleMatcher;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule\TreeRuleMatcher;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule\UnsupportedRuleException;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeDecorationRepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeRepositoryInterface;

interface PossibilitiesBuilderInterface
{
    /**
     * @param string $sizeSymbol
     * @return ?string[]
     */
    public function getBySize(string $sizeSymbol) : ?array;
}
