<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

interface ErrorMessageInterface
{
    public function getMessage() : string;

    public function getMessageTemplate() : string;

    /**
     * @return array<string,scalar>|null
     */
    public function getParameters() : ?array;

    public function getConstraintType() : ?string;
}
