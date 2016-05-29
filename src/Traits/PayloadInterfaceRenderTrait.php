<?php

namespace Asmaster\EquipTwig\Traits;

use Equip\Adr\PayloadInterface;

trait PayloadInterfaceRenderTrait
{
    /**
     * @var \Equip\Adr\PayloadInterface
     */
    protected $payload;

    /**
     * @param string $template The template name
     * @param array  $output   The output produced by the domain layer
     *
     * @return PayloadInterface
     */
    protected function render($template, array $output = [])
    {
        return $this->payload
            ->withStatus(PayloadInterface::STATUS_OK)
            ->withSetting('template', $template)
            ->withOutput($output);
    }
}
