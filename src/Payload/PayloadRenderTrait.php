<?php
declare(strict_types=1);

namespace AlexMasterov\EquipTwig\Payload;

use Equip\Adr\PayloadInterface;
use Equip\Payload;

trait PayloadRenderTrait
{
    protected function render(string $template, array $output = []): PayloadInterface
    {
        return (new Payload)
            ->withStatus(Payload::STATUS_OK)
            ->withSetting('template', $template)
            ->withOutput($output);
    }
}
