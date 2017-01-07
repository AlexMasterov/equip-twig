<?php

namespace AlexMasterov\EquipTwig\Traits;

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
     * @param string $template Template name
     * @param array  $output   The output produced by the domain layer
     *
     * @return Payload
     */
    protected function render($template, array $output = [])
    {
        return $this->payload()
            ->withStatus(Payload::STATUS_OK)
            ->withOutput(compact('template') + $output);
    }
}
