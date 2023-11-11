<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraintValidator;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessage;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidConstraintTypeException;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidValueTypeException;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureCollectionInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Row;

/**
 * @see OnlyNestedFeatureSymbols
 */
class OnlyNestedFeatureSymbolsValidator extends AbstractConstraintValidator
{
    const ERROR_MESSAGE_NOT_ALLOWED = 'Type `{TYPE}` not allowed, only `{ALLOWED}`';

    public function validate(mixed $value, ConstraintInterface $constraint): void
    {
        if (! $constraint instanceof OnlyNestedFeatureSymbols) {
            throw new InvalidConstraintTypeException($constraint, OnlyNestedFeatureSymbols::class);
        }

        if (! $value instanceof Row) {
            throw new InvalidValueTypeException($value, Row::class);
        }

        foreach ($value->getFeatures() as $feature) {
            if ($feature instanceof FeatureCollectionInterface) {
                foreach ($feature as $nestedFeature) {
                    if (is_a($nestedFeature, $constraint->nestedFeatureType) && ! in_array($nestedFeature->getFeatureSymbol(), $constraint->allowedSymbols)) {
                        $errorParams = ['{TYPE}' => $nestedFeature->getFeatureSymbol(), '{ALLOWED}' => implode(', ', $constraint->allowedSymbols)];
                        $this->context->addError(new ErrorMessage(self::ERROR_MESSAGE_NOT_ALLOWED, $errorParams, OnlyNestedFeatureSymbols::class ));
                    }
                }
            }
        }
    }
}
