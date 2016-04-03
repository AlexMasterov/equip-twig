<?php

namespace Asmaster\EquipTwig;

use Equip\Payload;
use Equip\Adr\PayloadInterface;
use Equip\Formatter\HtmlFormatter;
use Lukasoppermann\Httpstatus\Httpstatus;

class TwigFormatter extends HtmlFormatter
{
    /**
     * @var Twig_Environment
     */
    protected $environment;

    /**
     * @param Twig_Environment $environment
     * @param Httpstatus       $httpStatus
     */
    public function __construct(\Twig_Environment $environment, Httpstatus $httpStatus)
    {
        $this->environment = $environment;
        parent::__construct($httpStatus);
    }

    /**
     * @param PayloadInterface $payload
     * @return string
     */
    public function body(PayloadInterface $payload)
    {
        $template = $payload->getTemplate();
        $output = $payload->getOutput();

        return $this->environment->render($template, $output);
    }
}
