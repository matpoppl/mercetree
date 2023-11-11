<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraintValidator;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessage;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidConstraintTypeException;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidValueTypeException;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTree;

/**
 * @see UnusedPossibilities
 */
class UnusedPossibilitiesValidator extends AbstractConstraintValidator
{
    const ERROR_UNUSED = "You must use every decoration. Select `{COUNT}` more decorations from `{SYMBOLS}`";

    public function validate(mixed $value, ConstraintInterface $constraint): void
    {
        if (! $constraint instanceof UnusedPossibilities) {
            throw new InvalidConstraintTypeException($constraint, UnusedPossibilities::class);
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

        $validSymbols = array_intersect_key($constraint->symbols, $uniqueSymbols);
        $countValidSymbols = count($validSymbols);

        if ($countValidSymbols === $constraint->totalSlotsCount) {
            return;
        }

        $numberOfPossibilities = $constraint->totalSlotsCount - $countValidSymbols;
        $unusedSymbols = array_diff_key($constraint->symbols, $uniqueSymbols);

        $symbols = 'SYMBOL('.implode('), SYMBOL(', $unusedSymbols).')';

        $error = new ErrorMessage(
            self::ERROR_UNUSED,
            ['{COUNT}' => $numberOfPossibilities, '{SYMBOLS}' => $symbols],
            UnusedPossibilities::class
        );

        $this->context->addError($error);
    }
}
