<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessageInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ValidationContextInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Row;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\ValidationContext;
use Mateusz\Mercetree\TreeConfigurator\Feature\SizeSymbol;
use PHPUnit\Framework\TestCase;

/**
 * @covers RowFeatureCount
 * @covers RowFeatureCountValidator
 * @uses ValidationContext
 * @uses Row
 * @uses SizeSymbol
 */
class RowFeatureCountValidatorTest extends TestCase
{
    const MIN = 2;
    const MAX = 4;

    private function validate(Row $row): ValidationContextInterface
    {
        $context = new ValidationContext();
        $constraint = new RowFeatureCount(min: self::MIN, max: self::MAX);
        $validator = new RowFeatureCountValidator($context);
        $validator->validate($row, $constraint);
        return $context;
    }

    /**
     * @return ErrorMessageInterface[]
     */
    private function filterErrors(Row $row): array
    {
        return array_filter($this->validate($row)->getErrors(), fn(ErrorMessageInterface $error) => RowFeatureCount::class === $error->getConstraintType());
    }

    /**
     * @group Constraints
     * @group Constraint\RowFeatureCountValidator
     */
    public function testValidator()
    {
        $row = new Row('test', self::createMock(ConstraintCollectionInterface::class));

        for ($i = 0; $i < self::MIN; $i++) {
            $errors = $this->filterErrors($row);
            self::assertNotEmpty($errors, 'Below valid range');
            foreach ($errors as $error) {
                self::assertEquals(RowFeatureCountValidator::ERROR_MESSAGE_MIN, $error->getMessageTemplate());
            }

            $row->add(new SizeSymbol('foobar'));
        }

        for ($i = self::MIN; $i <= self::MAX; $i++) {
            $errors = $this->filterErrors($row);
            self::assertEmpty($errors, 'In range');
            $row->add(new SizeSymbol('foobar'));
        }

        for ($i = 0; $i < self::MAX; $i++) {
            $errors = $this->filterErrors($row);
            self::assertNotEmpty($errors, 'Above valid range');
            foreach ($errors as $error) {
                self::assertEquals(RowFeatureCountValidator::ERROR_MESSAGE_MAX, $error->getMessageTemplate());
            }
            $row->add(new SizeSymbol('foobar'));
        }
    }
}
