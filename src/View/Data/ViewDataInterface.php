<?php

namespace Mateusz\Mercetree\View\Data;

use Mateusz\Mercetree\Intl\Translator\TranslatorInterface;
use Mateusz\Mercetree\View\Renderer\ViewRendererInterface;

interface ViewDataInterface extends ViewRendererInterface
{
    public function has(string $id) : bool;

    public function get(string $id, mixed $default = null) : mixed;

    public function getTranslator() : TranslatorInterface;
}
