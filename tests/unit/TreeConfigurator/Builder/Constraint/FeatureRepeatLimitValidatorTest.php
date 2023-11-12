<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessageInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ValidationContextInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Row;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\ValidationContext;
use Mateusz\Mercetree\TreeConfigurator\Feature\Bauble;
use PHPUnit\Framework\TestCase;

/**
 * @covers FeatureRepeatLimit
 * @covers FeatureRepeatLimitValidator
 * @uses ValidationContext
 * @uses Bauble
 * @uses Row
 */
class FeatureRepeatLimitValidatorTest extends TestCase
{
    const MIN = 2;
    const MAX = 4;

    private function validate(Row $row): ValidationContextInterface
    {
        $context = new ValidationContext();
        $constraint = new FeatureRepeatLimit(min: self::MIN, max: self::MAX);
        $validator = new FeatureRepeatLimitValidator($context);
        $validator->validate($row, $constraint);
        return $context;
    }

    /**
     * @param Row $row
     * @return ErrorMessageInterface[]
     */
    private function filterErrors(Row $row): array
    {
        return array_filter($this->validate($row)->getErrors(), fn(ErrorMessageInterface $error) => FeatureRepeatLimit::class === $error->getConstraintType());
    }

    /**
     * @group Constraints
     * @group FeatureRepeatLimit
     */
    public function testValidator()
    {
        $row = new Row('test', self::createMock(ConstraintCollectionInterface::class));

        for ($i = 0; $i < self::MIN; $i++) {
            $errors = $this->filterErrors($row);
            self::assertNotEmpty($errors, 'Below valid range');
            foreach ($errors as $error) {
                self::assertEquals(FeatureRepeatLimitValidator::ERROR_MESSAGE_MIN, $error->getMessageTemplate());
            }

            $row->add( Bauble::create(size: 'size', coating: 'coating', model: 'model') );
        }

        for ($i = self::MIN; $i <= self::MAX; $i++) {
            $errors = $this->filterErrors($row);
            self::assertEmpty($errors, 'In range');

            $row->add( Bauble::create(size: 'size', coating: 'coating', model: 'model') );
        }

        for ($i = 0; $i < self::MAX; $i++) {
            $errors = $this->filterErrors($row);
            self::assertNotEmpty($errors, 'Above valid range');
            foreach ($errors as $error) {
                self::assertEquals(FeatureRepeatLimitValidator::ERROR_MESSAGE_MAX, $error->getMessageTemplate());
            }

            $row->add( Bauble::create(size: 'size', coating: 'coating', model: 'model') );
        }
    }
}
