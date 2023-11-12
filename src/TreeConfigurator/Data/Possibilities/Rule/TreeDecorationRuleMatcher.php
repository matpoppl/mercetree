<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule;

use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeDecorationEntity;

class TreeDecorationRuleMatcher implements RuleMatcherInterface
{
    public function __invoke(string $name, array $expected, object $entity): array
    {
        if (! $entity instanceof TreeDecorationEntity) {
            throw new InvalidEntityException($entity, TreeDecorationEntity::class);
        }

        return match ($name) {
            'size' => array_filter($expected, fn($value) => $value === $entity->getSize()),
            'coating' => array_filter($expected, fn($value) => $value === $entity->getCoating()),
            'model' => array_filter($expected, fn($value) => $value === $entity->getModel()),
            default => throw new UnsupportedRuleException($name, ['size', 'coating', 'model']),
        };
    }
}
