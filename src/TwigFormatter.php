<?php

namespace Asmaster\EquipTwig;

use Equip\Adr\PayloadInterface;
use Equip\Formatter\HtmlFormatter;
use Twig_Environment as TwigEnvironment;

final class TwigFormatter extends HtmlFormatter
{
    /**
     * @var TwigEnvironment
     */
    private $environment;

    /**
     * @param TwigEnvironment $environment
     */
    public function __construct(TwigEnvironment $environment)
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
