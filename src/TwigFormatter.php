<?php
declare(strict_types=1);

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

    public function __construct(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function body(PayloadInterface $payload): string
    {
        return $this->render($payload);
    }

    private function render(PayloadInterface $payload): string
    {
        $template = $payload->getSetting('template');
        $output = $payload->getOutput();

        return $this->environment->render($template, $output);
    }
}
