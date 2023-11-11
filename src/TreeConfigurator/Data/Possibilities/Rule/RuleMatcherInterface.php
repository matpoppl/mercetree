<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule;

interface RuleMatcherInterface
{
    /**
     * @template T
     * @param string $name
     * @param array $expected
     * @param object<T> $entity
     * @throws InvalidEntityException
     * @throws UnsupportedRuleException
     * @return array
     */
    public function __invoke(string $name, array $expected, object $entity) : array;
}
