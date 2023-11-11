<?php

namespace Mateusz\Mercetree\Intl\Translator;

interface TranslatorInterface
{
    public function translateTemplated(string $template, array $params) : string;
}
