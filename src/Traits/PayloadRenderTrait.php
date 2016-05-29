<?php

namespace Asmaster\EquipTwig\Traits;

use Equip\Payload;

trait PayloadRenderTrait
{
    /**
     * @return Payload $payload
     */
    protected function payload()
    {
        return new Payload;
    }

    /**
     * @param string $template The template name
     * @param array  $output   The output produced by the domain layer
     *
     * @return Payload
     */
    protected function render($template, array $output = [])
    {
        return $this->payload()
            ->withStatus(Payload::STATUS_OK)
            ->withSetting('template', $template)
            ->withOutput($output);
    }
}
