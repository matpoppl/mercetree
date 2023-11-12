<?php

namespace TreeConfigurator\Decoration\Validation;

use Closure;
use Mateusz\Mercetree\TestApplication;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTreeProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTreeInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowExceptionInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\TreeValidatorInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\TreeValidatorResultInterface;
use Mateusz\Mercetree\TreeConfigurator\Feature\Bauble;
use Mateusz\Mercetree\TreeConfigurator\TreeConfiguratorComponentInterface as Component;
use PHPUnit\Framework\TestCase;
use Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessageInterface;

/**
 * @covers Constraint\FeatureRepeatLimit
 * @covers Constraint\FeatureRepeatLimitValidator
 * @covers Constraint\OnlyNestedFeature
 * @covers Constraint\OnlyNestedFeatureSymbolsValidator
 * @covers Constraint\RowCountValidator
 * @covers Constraint\RowFeatureCountValidator
 * @covers Constraint\UnknownPossibilities
 * @covers Constraint\UnknownPossibilitiesValidator
 * @covers Constraint\UnusedPossibilities
 * @covers Constraint\UnusedPossibilitiesValidator
 */
class BigTreeAcceptanceTest extends TestCase
{
    /**
     * @group BigTree\RowFeatureCount
     * @group BigTree\FeatureRepeatLimit
     * @group BigTree\RowOnlyNestedFeatureSymbols
     * @group BigTree\BuiltTree
     * @group BigTree\UnknownPossibilities
     */
    public function testApplication(): Component
    {
        $app = TestApplication::getInstance();

        $component = $app->getComponent(Component::class);

        self::assertInstanceOf(Component::class, $component);

        return $component;
    }

    /**
     * @depends testApplication
     * @group BigTree\RowFeatureCount
     * @group BigTree\FeatureRepeatLimit
     * @group BigTree\RowOnlyNestedFeatureSymbols
     * @group BigTree\BuiltTree
     * @group BigTree\UnknownPossibilities
     */
    public function testValidatorCreation()
    {
        self::assertInstanceOf(TreeValidatorInterface::class, $this->getValidator());
    }

    /**
     * @depends testApplication
     * @group BigTree\RowFeatureCount
     * @group BigTree\FeatureRepeatLimit
     * @group BigTree\RowOnlyNestedFeatureSymbols
     * @group BigTree\BuiltTree
     * @group BigTree\UnknownPossibilities
     */
    public function testComponent(Component $component): BuiltTreeProviderInterface
    {
        $builtTreeProvider = $component->getBuiltTreeProvider();

        self::assertInstanceOf(BuiltTreeProviderInterface::class, $builtTreeProvider);

        return $builtTreeProvider;
    }

    /**
     * @depends testComponent
     * @group BigTree\RowFeatureCount
     * @group BigTree\FeatureRepeatLimit
     * @group BigTree\RowOnlyNestedFeatureSymbols
     * @group BigTree\BuiltTree
     * @group BigTree\UnknownPossibilities
     */
    public function testBuiltTreeProvider(BuiltTreeProviderInterface $builtTreeProvider): BuiltTreeInterface
    {
        $builtTree = $builtTreeProvider->get('tree:big');

        self::assertInstanceOf(BuiltTreeInterface::class, $builtTree);

        return $builtTree;
    }

    /**
     * @depends testBuiltTreeProvider
     */
    public function testRowDontExists(BuiltTreeInterface $builtTree)
    {
        self::expectException(RowExceptionInterface::class);
        self::expectExceptionCode(RowExceptionInterface::CODE_DONT_EXISTS);

        $builtTree->getRow('missing');
    }

    /**
     * @depends testBuiltTreeProvider
     */
    public function testRowExistence(BuiltTreeInterface $builtTree)
    {
        self::assertCount(6, $builtTree->getRows());
        self::assertTrue($builtTree->getRows()->has('row0'));
        self::assertTrue($builtTree->getRows()->has('row1'));
        self::assertTrue($builtTree->getRows()->has('row2'));
        self::assertTrue($builtTree->getRows()->has('row3'));
        self::assertTrue($builtTree->getRows()->has('row4'));
        self::assertTrue($builtTree->getRows()->has('row5'));

        $errors = self::filterErrorsByConstraint($this->getValidator()->validate($builtTree)->getTreeErrors(), Constraint\RowCount::class);
        self::assertEmpty($errors);
    }

    /**
     * @depends testBuiltTreeProvider
     * @group BigTree\BuiltTree
     */
    public function testUnusedPossibilities(BuiltTreeInterface $builtTree)
    {
        $decorationsConfig = TestApplication::getInstance()->getTestConfig('tree-decorations');
        $decorationsConfig = $decorationsConfig['options'];
        $decorationsConfig = [...$decorationsConfig['small'], ...$decorationsConfig['medium'], ...$decorationsConfig['big']];

        $decorationsCount = count($decorationsConfig);
        // use all decorations except last to ensure an error
        $insufficientCount = $decorationsCount - 1;
        $isLastIteration = false;

        for ($step = 0; $step < $decorationsCount; $step++) {

            // last iteration/step
            if ($step === $insufficientCount) {
                // use all decorations
                $insufficientCount = $decorationsCount;
                $isLastIteration = true;
            }

            $useInStepCount = min($insufficientCount, ($step % $insufficientCount) + 1);

            // populate
            $nthSlotInTree = 0;
            foreach ([
                 'row0' => 6,
                 'row1' => 5,
                 'row2' => 4,
                 'row3' => 3,
                 'row4' => 2,
                 'row5' => 1
             ] as $rowId => $slotsInRowCount) {
                $row = $builtTree->getRow($rowId)->reset();
                while ($slotsInRowCount-- > 0) {
                    // add decorations available in current step
                    $row->add(Bauble::createFromArray($decorationsConfig[$nthSlotInTree++ % $useInStepCount]));
                }
            }

            // test
            if ($isLastIteration) {
                $errors = self::filterErrorsByConstraint($this->getValidator()->validate($builtTree)->getTreeErrors(), Constraint\UnusedPossibilities::class);
                self::assertEmpty($errors, 'All decorations used at this point');
            } else {
                $errors = self::filterErrorsByConstraint($this->getValidator()->validate($builtTree)->getTreeErrors(), Constraint\UnusedPossibilities::class);
                self::assertNotEmpty($errors, 'Still not using all decorations');
            }
        }
    }

    /**
     * Check decoration unknown decorations
     * @depends testBuiltTreeProvider
     * @group BigTree\UnknownPossibilities
     */
    public function testUnknownPossibilities(BuiltTreeInterface $builtTree)
    {
        $builtTree->getRow('row0')->reset();
        $builtTree->getRow('row1')->reset();
        $builtTree->getRow('row2')->reset();
        $builtTree->getRow('row3')->reset();
        $builtTree->getRow('row4')->reset();
        $builtTree->getRow('row5')->reset();

        $errors = self::filterErrorsByConstraint($this->getValidator()->validate($builtTree)->getTreeErrors(), Constraint\UnknownPossibilities::class);
        self::assertEmpty($errors);

        $this->populateValidTree($builtTree);

        $errors = self::filterErrorsByConstraint($this->getValidator()->validate($builtTree)->getTreeErrors(), Constraint\UnknownPossibilities::class);
        self::assertEmpty($errors);

        // unknown in filled tree
        $builtTree->getRow('row4')->reset()->add(Bauble::create(size: 'unknown', coating: 'unknown', model: 'unknown'));
        $errors = self::filterErrorsByConstraint($this->getValidator()->validate($builtTree)->getTreeErrors(), Constraint\UnknownPossibilities::class);
        self::assertNotEmpty($errors);
        foreach ($errors as $error) {
            self::assertEquals(Constraint\UnknownPossibilitiesValidator::ERROR_UNKNOWN, $error->getMessageTemplate());
        }

        // unknown in empty tree
        $builtTree->getRow('row0')->reset();
        $builtTree->getRow('row1')->reset();
        $builtTree->getRow('row2')->reset();
        $builtTree->getRow('row3')->reset();
        $builtTree->getRow('row4')->reset();
        $builtTree->getRow('row5')->reset()->add(Bauble::create(size: 'unknown', coating: 'unknown', model: 'unknown'));
        $errors = self::filterErrorsByConstraint($this->getValidator()->validate($builtTree)->getTreeErrors(), Constraint\UnknownPossibilities::class);
        self::assertNotEmpty($errors);
        foreach ($errors as $error) {
            self::assertEquals(Constraint\UnknownPossibilitiesValidator::ERROR_UNKNOWN, $error->getMessageTemplate());
        }
    }

    /**
     * Check decoration count in all rows
     * @depends testBuiltTreeProvider
     * @group BigTree\RowFeatureCount
     */
    public function testRowFeatureCount(BuiltTreeInterface $builtTree): BuiltTreeInterface
    {
        foreach ([
             'row0' => 6,
             'row1' => 5,
             'row2' => 4,
             'row3' => 3,
             'row4' => 2,
             'row5' => 1,
         ] as $rowId => $rowsCount) {

            $filter = self::createRowErrorFilter($rowId, Constraint\RowFeatureCount::class);
            $row = $builtTree->getRow($rowId)->reset();

            // UNDERFLOW COUNT
            for ($i = 0; $i < $rowsCount; $i++) {
                $errors = $filter($builtTree);
                self::assertNotEmpty($errors, "Has Count error in `{$rowId}`");
                $row->add(Bauble::create(size: 'small', coating: 'color:red'));

                foreach ($errors as $error) {
                    self::assertEquals(Constraint\RowFeatureCountValidator::ERROR_MESSAGE_MIN, $error->getMessageTemplate());
                }
            }

            // VALID COUNT

            self::assertEmpty($filter($builtTree), "No Count error in `{$rowId}`");

            // OVERFLOW COUNT

            $row->add(Bauble::create(size: 'small', coating: 'color:red'));

            $errors = $filter($builtTree);
            self::assertNotEmpty($errors, "Has Count error in `{$rowId}`");
            foreach ($errors as $error) {
                self::assertEquals(Constraint\RowFeatureCountValidator::ERROR_MESSAGE_MAX, $error->getMessageTemplate());
            }
        }

        return $builtTree;
    }

    /**
     * Check decoration repeats in all rows
     * @depends testBuiltTreeProvider
     * @group BigTree\FeatureRepeatLimit
     */
    public function testFeatureRepeatLimit(BuiltTreeInterface $builtTree): BuiltTreeInterface
    {
        foreach ([
             'row0' => 1,
             'row1' => 1,
             'row2' => 1,
             'row3' => 1,
             'row4' => 1,
             'row5' => 1,
         ] as $rowId => $maxAllowedRepeats) {

            $filter = self::createRowErrorFilter($rowId, Constraint\FeatureRepeatLimit::class);
            $row = $builtTree->getRow($rowId)->reset();

            // VALID REPEATS
            for ($i = 0; $i < $maxAllowedRepeats; $i++) {
                $row->add(Bauble::create(size: 'small', coating: 'color:red'));
                self::assertEmpty($filter($builtTree), "No Repeat error in `{$rowId}` after `{$i}` repeats");
            }

            // OVERFLOW REPEATS
            $row->add(Bauble::create(size: 'small', coating: 'color:red'));

            $errors = $filter($builtTree);
            self::assertNotEmpty($errors, "Has Repeat error in `{$rowId}` after `{$i}` repeats");
            foreach ($errors as $error) {
                self::assertEquals(Constraint\FeatureRepeatLimitValidator::ERROR_MESSAGE_MAX, $error->getMessageTemplate());
            }
        }

        return $builtTree;
    }

    /**
     * @depends testBuiltTreeProvider
     * @group BigTree\RowOnlyNestedFeatureSymbols
     */
    public function testOnlyNestedFeatureSymbols(BuiltTreeInterface $builtTree): BuiltTreeInterface
    {
        $treeDecorations = TestApplication::getInstance()->getTestConfig('tree-decorations');
        $treeDecorations = $treeDecorations['options'];

        $knownValids = [...$treeDecorations['small'], ...$treeDecorations['medium'], ...$treeDecorations['big']];
        $knownInvalids = [];

        foreach (['row0', 'row1', 'row2', 'row3', 'row4', 'row5'] as $rowId) {
            $filter = self::createRowErrorFilter($rowId, Constraint\OnlyNestedFeatureSymbols::class);
            $row = $builtTree->getRow($rowId)->reset();

            foreach ($knownValids as $knownValid) {
                $row->add(Bauble::createFromArray($knownValid));
                self::assertEmpty($filter($builtTree), "No errors");
            }

            foreach ($knownInvalids as $knownInvalid) {
                $row->reset()->add(Bauble::createFromArray($knownInvalid));

                $errors = $filter($builtTree);
                self::assertNotEmpty($errors, "Has errors");
                foreach ($errors as $error) {
                    self::assertEquals(Constraint\OnlyNestedFeatureSymbolsValidator::ERROR_MESSAGE_NOT_ALLOWED, $error->getMessageTemplate());
                }
            }
        }

        return $builtTree;
    }

    /**
     * @depends testBuiltTreeProvider
     * @group BigTree\BuiltTree
     */
    public function testValidTree(BuiltTreeInterface $builtTree)
    {
        $this->populateValidTree($builtTree);

        $validationResults = $this->getValidator()->validate($builtTree);

        self::assertInstanceOf(TreeValidatorResultInterface::class, $validationResults);
        self::assertEmpty($validationResults->getTreeErrors(), 'No tree errors');
        self::assertEmpty($validationResults->getRowErrors('row0'), 'No row0 errors');
        self::assertEmpty($validationResults->getRowErrors('row1'), 'No row1 errors');
        self::assertEmpty($validationResults->getRowErrors('row2'), 'No row2 errors');
        self::assertEmpty($validationResults->getRowErrors('row3'), 'No row3 errors');
        self::assertEmpty($validationResults->getRowErrors('row4'), 'No row4 errors');
        self::assertEmpty($validationResults->getRowErrors('row5'), 'No row5 errors');
        self::assertTrue($validationResults->isValid(), 'Tree is valid');
    }

    private function populateValidTree(BuiltTreeInterface $builtTree): void
    {
        $builtTree->getRow('row0')
            ->reset()
            ->add(Bauble::create(size: 'big', coating: 'hand-paint', model: 'showman'))
            ->add(Bauble::create(size: 'big', coating: 'hand-paint', model: 'santa'))
            ->add(Bauble::create(size: 'big', coating: 'hand-paint', model: 'reindeer'))
            ->add(Bauble::create(size: 'small', coating: 'color:red'))
            ->add(Bauble::create(size: 'small', coating: 'color:blue'))
            ->add(Bauble::create(size: 'medium', coating: 'color:green'));

        $builtTree->getRow('row1')
            ->reset()
            ->add(Bauble::create(size: 'big', coating: 'hand-paint', model: 'showman'))
            ->add(Bauble::create(size: 'big', coating: 'hand-paint', model: 'santa'))
            ->add(Bauble::create(size: 'big', coating: 'hand-paint', model: 'reindeer'))
            ->add(Bauble::create(size: 'small', coating: 'color:red'))
            ->add(Bauble::create(size: 'medium', coating: 'color:green'));

        $builtTree->getRow('row2')
            ->reset()
            ->add(Bauble::create(size: 'small', coating: 'color:red'))
            ->add(Bauble::create(size: 'small', coating: 'color:blue'))
            ->add(Bauble::create(size: 'small', coating: 'color:yellow'))
            ->add(Bauble::create(size: 'medium', coating: 'color:green'));

        $builtTree->getRow('row3')
            ->reset()
            ->add(Bauble::create(size: 'medium', coating: 'color:white'))
            ->add(Bauble::create(size: 'medium', coating: 'color:pink'))
            ->add(Bauble::create(size: 'small', coating: 'color:yellow'));

        $builtTree->getRow('row4')
            ->reset()
            ->add(Bauble::create(size: 'medium', coating: 'color:green'))
            ->add(Bauble::create(size: 'small', coating: 'color:yellow'));

        $builtTree->getRow('row5')
            ->reset()
            ->add(Bauble::create(size: 'medium', coating: 'color:pink'));
    }

    /**
     * @param string $rowId
     * @param class-string $constraintType
     * @return Closure(BuiltTreeInterface):array<ErrorMessageInterface>
     */
    public function createRowErrorFilter(string $rowId, string $constraintType): Closure
    {
        $createFilter = function (string $constraintType) {
            return fn($errors) => array_filter($errors, fn($error) => $constraintType === $error->getConstraintType());
        };

        $createValidator = function (TreeValidatorInterface $validator, string $rowId, Closure $filter) {
            return fn($builtTree) => $filter($validator->validate($builtTree)->getRowErrors($rowId));
        };

        return $createValidator($this->getValidator(), $rowId, $createFilter($constraintType));
    }

    /**
     * @param ErrorMessageInterface[] $errors
     * @param class-string $constraintType
     * @return ErrorMessageInterface[]
     */
    private static function filterErrorsByConstraint(array $errors, string $constraintType): array
    {
        return array_filter($errors, fn($error) => $constraintType === $error->getConstraintType());
    }

    private function getValidator(): TreeValidatorInterface
    {
        return TestApplication::getInstance()->getComponent(Component::class)->getTreeValidator();
    }
}
