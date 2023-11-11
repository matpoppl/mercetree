<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Validator;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ValidationContextInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTree;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTreeInterface;

class TreeValidator implements TreeValidatorInterface
{
    private ValidationContextInterface $validationContext;

    public function __construct()
    {
        $this->validationContext = new ValidationContext();
    }

    public function validate(BuiltTreeInterface $tree): TreeValidatorResultInterface
    {
        $treeErrors = [];

        if (! $this->validationContext->validate($tree, $tree->getConstraints())) {
            $treeErrors = $this->validationContext->getErrors();
        }

        $rowsErrors = [];

        foreach ($tree->getRows() as $row) {

            if ($this->validationContext->validate($row, $row->getConstraints())) {
                continue;
            }

            $rowsErrors[$row->getRowId()] = $this->validationContext->getErrors();
        }

        return new TreeValidatorResult($treeErrors, $rowsErrors);
    }
}
