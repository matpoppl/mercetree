<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule;

use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity;

class TreeRuleMatcher implements RuleMatcherInterface
{
    /**
     * @implements TreeEntity
     */
    public function __invoke(string $name, array $expected, object $entity): array
    {
        if (! $entity instanceof TreeEntity) {
            throw new InvalidEntityException($entity, TreeEntity::class);
        }

        return match ($name) {
            'size' => array_filter((array) $expected, fn($value) => $value === $entity->getSize()),
            'rows' => array_filter((array) $expected, fn($value) => $value === $entity->getRows()),
            default => throw new UnsupportedRuleException($name, ['size','rows']),
        };
    }
}
