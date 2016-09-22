<?php

namespace AlexMasterov\EquipTwig;

use Equip\Adr\PayloadInterface;
use Equip\Formatter\HtmlFormatter;
use Twig_Environment;

final class TwigFormatter extends HtmlFormatter
{
    /**
     * @var Twig_Environment
     */
    private $environment;

    /**
     * @param Twig_Environment $environment
     */
    public function __construct(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @param PayloadInterface $payload
     *
     * @return string
     */
    public function body(PayloadInterface $payload)
    {
        return $this->render($payload);
    }

    /**
     * @param PayloadInterface $payload
     *
     * @return string
     */
    private function render(PayloadInterface $payload)
    {
        $template = $payload->getSetting('template');
        $output = $payload->getOutput();

        return $this->environment->render($template, $output);
    }
}
