<?php

namespace Mateusz\Mercetree\View\Data;

use Mateusz\Mercetree\Intl\Translator\TranslatorInterface;

interface ViewDataInterface
{
    public function has(string $id) : bool;

    public function get(string $id, mixed $default = null) : mixed;

    public function getTranslator() : TranslatorInterface;
}
