<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessageInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ValidationContextInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowsInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\ValidationContext;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Rows;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTree;
use PHPUnit\Framework\TestCase;

/**
 * @covers RowCount
 * @covers RowCountValidator
 * @uses ValidationContext
 * @uses Rows
 * @uses BuiltTree
 */
class RowCountValidatorTest extends TestCase
{
    const MIN = 2;
    const MAX = 4;

    private function validate(BuiltTree $tree): ValidationContextInterface
    {
        $context = new ValidationContext();
        $constraint = new RowCount(min: self::MIN, max: self::MAX);
        $validator = new RowCountValidator($context);
        $validator->validate($tree, $constraint);
        return $context;
    }

    /**
     * @return ErrorMessageInterface[]
     */
    private function filterErrors(BuiltTree $tree): array
    {
        return array_filter($this->validate($tree)->getErrors(), fn(ErrorMessageInterface $error) => RowCount::class === $error->getConstraintType());
    }

    private function createTree(int $rowsCount) : BuiltTree
    {
        $constraintCollection = self::createMock(ConstraintCollectionInterface::class);
        $row = self::createMock(RowsInterface::class);
        $rows = new Rows(array_fill(0, $rowsCount, $row));
        return new BuiltTree($rows, $constraintCollection);
    }

    /**
     * @group Constraints
     * @group Constraint\RowCountValidator
     */
    public function testValidator()
    {
        for ($i = 0; $i < self::MIN; $i++) {
            $errors = $this->filterErrors($this->createTree($i));
            self::assertNotEmpty($errors, 'Below valid range');
            foreach ($errors as $error) {
                self::assertEquals(RowCountValidator::ERROR_MESSAGE_MIN, $error->getMessageTemplate());
            }
        }

        for ($i = self::MIN; $i <= self::MAX; $i++) {
            $errors = $this->filterErrors($this->createTree($i));
            self::assertEmpty($errors, 'In range');
        }

        for ($i = self::MAX + 1, $z = self::MAX + 3; $i < $z; $i++) {
            $errors = $this->filterErrors($this->createTree($i));
            self::assertNotEmpty($errors, 'Above valid range');
            foreach ($errors as $error) {
                self::assertEquals(RowCountValidator::ERROR_MESSAGE_MAX, $error->getMessageTemplate());
            }
        }
    }
}
