<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

class ErrorMessage implements ErrorMessageInterface
{
    public function __construct(private readonly string $messageTemplate, private readonly ?array $parameters = null, private readonly ?string $constraintType = null)
    { }

    public function getMessage() : string
    {
        return (null === $this->parameters) ? $this->messageTemplate : strtr($this->messageTemplate, $this->parameters);
    }

    public function getMessageTemplate() : string
    {
        return $this->messageTemplate;
    }

    public function getParameters() : ?array
    {
        return $this->parameters;
    }

    public function getConstraintType() : ?string
    {
        return $this->constraintType;
    }
}
