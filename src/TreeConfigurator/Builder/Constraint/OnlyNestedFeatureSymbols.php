<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraint;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidOptionsException;

/**
 * @extends AbstractConstraint<OnlyNestedFeatureSymbolsValidator>
 */
class OnlyNestedFeatureSymbols extends AbstractConstraint
{
    /**
     * @template T
     * @param class-string<T> $nestedFeatureType
     * @param string[] $allowedSymbols
     */
    public function __construct(public readonly string $nestedFeatureType, public readonly array $allowedSymbols)
    {
        $typeExists = class_exists($nestedFeatureType) || interface_exists($nestedFeatureType);

        if (! $typeExists) {
            throw new InvalidOptionsException("Nested feature type `{$nestedFeatureType}` don't exists");
        }

        foreach ($allowedSymbols as $symbol) {
            if (! is_string($symbol)) {
                throw new InvalidOptionsException("Non-string feature symbol `{$symbol}`");
            }
        }
    }

    public function getValidatorType(): string
    {
        return OnlyNestedFeatureSymbolsValidator::class;
    }
}
