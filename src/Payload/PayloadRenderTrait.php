<?php

namespace AlexMasterov\EquipTwig\Payload;

use Equip\Payload;

trait PayloadRenderTrait
{
    /**
     * @param string $template
     * @param array  $output
     *
     * @return PayloadInterface
     */
    protected function render($template, array $output = [])
    {
        return (new Payload)
            ->withStatus(Payload::STATUS_OK)
            ->withSetting('template', $template)
            ->withOutput($output);
    }
}
