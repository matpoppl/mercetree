<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraintValidator;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessage;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidConstraintTypeException;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidValueTypeException;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureCollectionInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowInterface;

/**
 * @see OnlyNestedFeatureSymbols
 */
class OnlyNestedFeatureSymbolsValidator extends AbstractConstraintValidator
{
    const ERROR_MESSAGE_NOT_ALLOWED = 'Type `{TYPE}` not allowed, only `{ALLOWED}`';
    const ERROR_MESSAGE_FEATURE_COLLECTION_NOT_FOUND = 'Feature collection not found';
    const ERROR_MESSAGE_NESTED_FEATURE_NOT_FOUND = 'Nested feature not found';

    public function validate(mixed $value, ConstraintInterface $constraint): void
    {
        if (! $constraint instanceof OnlyNestedFeatureSymbols) {
            throw new InvalidConstraintTypeException($constraint, OnlyNestedFeatureSymbols::class);
        }

        if (! $value instanceof RowInterface) {
            throw new InvalidValueTypeException($value, RowInterface::class);
        }

        $nestedCollectionFound = false;
        $nestedFeatureTypeFound = false;

        $value->getFeatures();

        foreach ($value->getFeatures() as $feature) {
            if (! $feature instanceof FeatureCollectionInterface) {
                continue;
            }

            $nestedCollectionFound = true;

            foreach ($feature as $nestedFeature) {

                if (! is_a($nestedFeature, $constraint->nestedFeatureType)) {
                    continue;
                }

                $nestedFeatureTypeFound = true;

                if (in_array($nestedFeature->getFeatureSymbol(), $constraint->allowedSymbols)) {
                    continue;
                }

                $errorParams = ['{TYPE}' => $nestedFeature->getFeatureSymbol(), '{ALLOWED}' => implode(', ', $constraint->allowedSymbols)];
                $this->context->addError(new ErrorMessage(self::ERROR_MESSAGE_NOT_ALLOWED, $errorParams, OnlyNestedFeatureSymbols::class ));
            }
        }

        if (! $nestedCollectionFound) {
            $this->context->addError(new ErrorMessage(self::ERROR_MESSAGE_FEATURE_COLLECTION_NOT_FOUND, [], OnlyNestedFeatureSymbols::class ));
        } else if (! $nestedFeatureTypeFound) {
            $this->context->addError(new ErrorMessage(self::ERROR_MESSAGE_NESTED_FEATURE_NOT_FOUND, [], OnlyNestedFeatureSymbols::class ));
        }
    }
}
