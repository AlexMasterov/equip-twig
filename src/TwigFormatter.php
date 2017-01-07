<?php

namespace AlexMasterov\EquipTwig;

use Equip\Adr\PayloadInterface;
use Equip\Formatter\HtmlFormatter;
use Lukasoppermann\Httpstatus\Httpstatus;
use Twig_Environment;

class TwigFormatter extends HtmlFormatter
{
    /**
     * @var Twig_Environment
     */
    protected $environment;

    /**
     * @param Twig_Environment  $environment
     * @param Httpstatus       $httpStatus
     */
    public function __construct(
        Twig_Environment $environment,
        Httpstatus $httpStatus
    )
    {
        $this->environment = $environment;
        parent::__construct($httpStatus);
    }

    /**
     * @param TemplatePayload $payload
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
    protected function render(PayloadInterface $payload)
    {
        $template = $this->template($payload);
        $output = $this->output($payload);

        return $this->environment->render($template, $output);
    }

    /**
     * @param PayloadInterface $payload
     *
     * @return string Template name
     */
    protected function template(PayloadInterface $payload)
    {
        return $payload->getOutput()['template'];
    }

    /**
     * @param PayloadInterface $payload
     *
     * @return array
     */
    protected function output(PayloadInterface $payload)
    {
        $output = $payload->getOutput();
        unset($output['template']);

        return $output;
    }
}
