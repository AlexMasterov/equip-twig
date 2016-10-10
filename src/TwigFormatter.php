<?php

namespace AlexMasterov\EquipTwig;

use Equip\Formatter\HtmlFormatter;
use Twig_Environment;

final class TwigFormatter extends HtmlFormatter
{
    /**
     * @var Twig_Environment
     */
    private $environment;

    /**
     * @var string
     */
    private $template;

    /**
     * @param Twig_Environment $environment
     */
    public function __construct(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Get a copy that uses a different template.
     *
     * @param string $template
     *
     * @return static
     */
    public function withTemplate($template)
    {
        $copy = clone $this;
        $copy->template = $template;

        return $copy;
    }

    /**
     * @inheritDoc
     */
    public function format($content)
    {
        return $this->environment->render($this->template, $content);
    }
}
