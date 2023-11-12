<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessageInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ValidationContextInterface;
use Mateusz\Mercetree\ProductConfigurator\Feature\SizeSymbolInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Row;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\ValidationContext;
use Mateusz\Mercetree\TreeConfigurator\Feature\Bauble;
use Mateusz\Mercetree\TreeConfigurator\Feature\SizeSymbol;
use PHPUnit\Framework\TestCase;

class OnlyNestedFeatureSymbolsValidatorTest extends TestCase
{
    private function validate(Row $row): ValidationContextInterface
    {
        $context = new ValidationContext();
        $constraint = new OnlyNestedFeatureSymbols(SizeSymbolInterface::class, ['size:foobar']);
        $validator = new OnlyNestedFeatureSymbolsValidator($context);
        $validator->validate($row, $constraint);
        return $context;
    }

    /**
     * @param Row $row
     * @return ErrorMessageInterface[]
     */
    private function filterErrors(Row $row): array
    {
        return array_filter($this->validate($row)->getErrors(), fn(ErrorMessageInterface $error) => OnlyNestedFeatureSymbols::class === $error->getConstraintType());
    }

    /**
     * @group Constraints
     * @group OnlyNestedFeatureSymbols
     */
    public function testFeatureCollection()
    {
        $row = new Row('test', self::createMock(ConstraintCollectionInterface::class));

        $row->add( Bauble::create(size: 'invalid', coating: 'coating', model: 'model') );
        $errors = $this->filterErrors($row);
        self::assertNotEmpty($errors);
        foreach ($errors as $error) {
            self::assertEquals(OnlyNestedFeatureSymbolsValidator::ERROR_MESSAGE_NOT_ALLOWED, $error->getMessageTemplate());
        }

        $row->reset()->add(Bauble::create(size: 'foobar', coating: 'coating', model: 'model'));
        self::assertEmpty($this->filterErrors($row));
    }

    /**
     * @group Constraints
     * @group OnlyNestedFeatureSymbols
     */
    public function testNonCollection()
    {
        $row = new Row('test', self::createMock(ConstraintCollectionInterface::class));

        $row->add( new SizeSymbol('foobar') );
        $errors = $this->filterErrors($row);
        self::assertNotEmpty($errors);
        foreach ($errors as $error) {
            self::assertEquals(OnlyNestedFeatureSymbolsValidator::ERROR_MESSAGE_FEATURE_COLLECTION_NOT_FOUND, $error->getMessageTemplate());
        }
    }
}
