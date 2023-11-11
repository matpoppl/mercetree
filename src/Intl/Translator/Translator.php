<?php

namespace Mateusz\Mercetree\Intl\Translator;

class Translator implements TranslatorInterface
{
    public function translateTemplated(string $template, array $params) : string
    {
        return strtr($template, $params);
    }
}
