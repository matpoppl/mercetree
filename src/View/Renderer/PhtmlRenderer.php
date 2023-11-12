<?php

namespace Mateusz\Mercetree\View\Renderer;

use Mateusz\Mercetree\Intl\Translator\TranslatorInterface;
use Mateusz\Mercetree\View\Data\ViewData;
use Mateusz\Mercetree\View\Data\ViewDataInterface;

class PhtmlRenderer implements ViewRendererInterface
{
    /**
     * @var string[]
     */
    private array $paths;

    public function __construct(private readonly TranslatorInterface $translator, array $paths)
    {
        if (empty($paths)) {
            throw new \UnexpectedValueException("`paths` arguments required");
        }

        foreach ($paths as $path) {
            $this->paths[] = rtrim($path, '\\/') . '/';
        }
    }

    public function render(string $template, array $data) : string
    {
        $sandbox = function($__pathname, ViewDataInterface $view) {
            ob_start();
            require $__pathname;
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        };

        $pathname = $this->findTemplatePathname($template);

        if (! $pathname) {
            throw TemplateException::notFound($pathname, $this->paths);
        }

        return $sandbox($pathname, new ViewData($this, $this->translator, $data));
    }

    public function findTemplatePathname(string $template) : ?string
    {
        foreach ($this->paths as $basePath) {
            $pathname = $basePath . $template;
            if (is_file($pathname) && is_readable($pathname)) {
                return $pathname;
            }
        }

        return null;
    }
}
