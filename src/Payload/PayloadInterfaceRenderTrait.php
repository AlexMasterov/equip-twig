<?php
declare(strict_types=1);

namespace AlexMasterov\EquipTwig\Payload;

use Equip\Adr\PayloadInterface;

trait PayloadInterfaceRenderTrait
{
    /**
     * @var PayloadInterface
     */
    protected $payload;

    protected function render(string $template, array $output = []): PayloadInterface
    {
        return $this->payload
            ->withStatus(PayloadInterface::STATUS_OK)
            ->withSetting('template', $template)
            ->withOutput($output);
    }
}
