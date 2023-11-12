<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Possibilities;

use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule\InvalidEntityException;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule\RuleMatcherInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule\TreeDecorationRuleMatcher;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule\TreeRuleMatcher;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule\UnsupportedRuleException;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeDecorationRepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeRepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeDecorationEntity;

/**
 * @deprecated Demo only. Helps with generating fake DB records
 */
class PossibilitiesBuilder implements PossibilitiesBuilderInterface
{
    private array $possibilities = [];

    /**
     * @throws InvalidEntityException
     * @throws UnsupportedRuleException
     */
    public function __construct(TreeRepositoryInterface $trees, TreeDecorationRepositoryInterface $decorations, array $ruleSets)
    {
        // @TODO move to config with rule sets
        $treeMatcher = new TreeRuleMatcher();
        $treeDecorationMatcher = new TreeDecorationRuleMatcher();

        foreach ($ruleSets as $rules) {
            $this->possibilities[] = [
                'trees' => $this->filterEntities($rules['tree'], $treeMatcher, $trees->getAll()),
                'decorations' => $this->filterEntities($rules['decoration'], $treeDecorationMatcher, $decorations->getAll()),
            ];
        }
    }

    /**
     * @throws InvalidEntityException
     * @throws UnsupportedRuleException
     */
    public function filterEntities(array $rules, RuleMatcherInterface $matcher, iterable $entities) : array
    {
        $matches = [];

        foreach ($entities as $entity) {
            foreach ($rules as $name => $expected) {

                // always accept items for this rule
                if ('__ANY__' === $expected) continue;

                $ruleMatches = $matcher($name, $expected, $entity);

                if (empty($ruleMatches)) {
                    // skip item with no match
                    continue 2;
                }
            }

            $matches[] = $entity;
        }

        return $matches;
    }

    public function getBySize(string $sizeSymbol) : array
    {
        foreach ($this->possibilities as $possibilities) {
            /** @var TreeEntity $tree */
            foreach ($possibilities['trees'] as $tree) {
                if ($sizeSymbol === $tree->getSize()) {
                    return $this->flattenPossibilities( $possibilities['decorations'] );
                }
            }
        }
        return [];
    }

    /**
     * @param TreeDecorationEntity[] $possibilities
     * @return string[]
     */
    public function flattenPossibilities(array $possibilities) : array
    {
        // model:bauble/size:small/coating(color:red)
        return array_map(fn($p) => "model:{$p->getModel()}/size:{$p->getSize()}/coating({$p->getCoating()})", $possibilities);
    }
}
