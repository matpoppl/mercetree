<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraintValidator;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessage;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidConstraintTypeException;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidValueTypeException;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Row;
use function min;
use function max;

/**
 * @see FeatureRepeatLimit
 */
class FeatureRepeatLimitValidator extends AbstractConstraintValidator
{
    const ERROR_MESSAGE_MIN = 'Expect at lest `{LIMIT}` symbol repeats. Symbol `{SYMBOL}` repeated `{COUNT}` times.';
    const ERROR_MESSAGE_MAX = 'Expect at most `{LIMIT}` symbol repeats. Symbol `{SYMBOL}` repeated `{COUNT}` times.';

    public function validate(mixed $value, ConstraintInterface $constraint): void
    {
        if (! $constraint instanceof FeatureRepeatLimit) {
            throw new InvalidConstraintTypeException($constraint, FeatureRepeatLimit::class);
        }

        if (! $value instanceof Row) {
            throw new InvalidValueTypeException($value, Row::class);
        }

        $symbols = [];
        foreach ($value->getFeatures() as $feature) {
            $symbols[] = $feature->getFeatureSymbol();
        }

        $values = array_count_values($symbols);

        if (empty($values)) {
            $min = $max = 0;
        } else {
            $min = min($values);
            $max = max($values);
        }

        if (null !== $constraint->min && $min < $constraint->min) {
            $featureSymbol = array_search($min, $values, true);
            $errorParams = ['{LIMIT}' => $constraint->min, '{SYMBOL}' => $featureSymbol, '{COUNT}' => $min];
            $this->context->addError(new ErrorMessage(self::ERROR_MESSAGE_MIN, $errorParams, FeatureRepeatLimit::class));
        }

        if (null !== $constraint->max && $max > $constraint->max) {
            $featureSymbol = array_search($max, $values, true);
            $errorParams = ['{LIMIT}' => $constraint->max, '{SYMBOL}' => $featureSymbol, '{COUNT}' => $max];
            $this->context->addError(new ErrorMessage(self::ERROR_MESSAGE_MAX, $errorParams, FeatureRepeatLimit::class));
        }
    }
}
