<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\Rule;

class UnsupportedRuleException extends \Exception
{
    public function __construct(string $name, array $expecting)
    {
        $expecting = implode(', ', $expecting);
        parent::__construct("Unsupported rule `{$name}`, expecting `[{$expecting}]`");
    }
}
