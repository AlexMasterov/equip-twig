<?php

namespace Asmaster\EquipTwig;

use Equip\Adr\PayloadInterface;
use Equip\Formatter\HtmlFormatter;
use Lukasoppermann\Httpstatus\Httpstatus;

class TwigFormatter extends HtmlFormatter
{
    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @param \Twig_Environment $environment
     * @param Httpstatus        $httpStatus
     */
    public function __construct(\Twig_Environment $environment, Httpstatus $httpStatus)
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
        $context = $this->context($payload);

        return $this->environment->render($template, $context);
    }

    /**
     * @param PayloadInterface $payload
     *
     * @return string
     */
    protected function template(PayloadInterface $payload)
    {
        return $payload->getOutput()['template'];
    }

    /**
     * @param PayloadInterface $payload
     *
     * @return array $context
     */
    protected function context(PayloadInterface $payload)
    {
        $context = $payload->getOutput();
        unset($context['template']);

        return $context;
    }
}
