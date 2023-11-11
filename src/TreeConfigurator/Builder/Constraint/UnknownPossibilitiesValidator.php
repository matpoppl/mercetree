<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraintValidator;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessage;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidConstraintTypeException;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidValueTypeException;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTree;

/**
 * @see UnknownPossibilities
 */
class UnknownPossibilitiesValidator extends AbstractConstraintValidator
{
    const ERROR_UNKNOWN = "Not valid symbols detected `{SYMBOLS}`";

    public function validate(mixed $value, ConstraintInterface $constraint): void
    {
        if (! $constraint instanceof UnknownPossibilities) {
            throw new InvalidConstraintTypeException($constraint, UnknownPossibilities::class);
        }

        if (! $value instanceof BuiltTree) {
            throw new InvalidValueTypeException($value, BuiltTree::class);
        }

        $uniqueSymbols = [];

        foreach ($value->getRows() as $row) {
            foreach ($row->getFeatures() as $feature) {
                $uniqueSymbols[ $feature->getFeatureSymbol() ] = true;
            }
        }

        $unknownSymbols = array_diff_key($uniqueSymbols, $constraint->symbols);

        if (empty($unknownSymbols)) {
            return;
        }

        $unknownSymbols = array_keys($unknownSymbols);

        $symbols = 'SYMBOL('.implode('), SYMBOL(', $unknownSymbols).')';

        $error = new ErrorMessage(
            self::ERROR_UNKNOWN,
            ['{SYMBOLS}' => $symbols],
            UnknownPossibilities::class
        );

        $this->context->addError($error);
    }
}
