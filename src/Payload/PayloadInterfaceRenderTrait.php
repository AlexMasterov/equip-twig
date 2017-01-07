<?php

namespace AlexMasterov\EquipTwig\Payload;

use Equip\Adr\PayloadInterface;

trait PayloadInterfaceRenderTrait
{
    /**
     * @var PayloadInterface
     */
    protected $payload;

    /**
     * @param string $template
     * @param array  $output
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
