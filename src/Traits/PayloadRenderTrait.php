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
     * @param string $template
     * @param array  $output
     *
     * @return Payload $payload
     */
    protected function render($template, array $output = [])
    {
        return $this->payload()
            ->withStatus(Payload::STATUS_OK)
            ->withOutput(compact('template') + $output);
    }
}
