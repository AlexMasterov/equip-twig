<?php

namespace AlexMasterov\EquipTwig\Tests\Traits;

use AlexMasterov\EquipTwig\Payload\PayloadRenderTrait;
use AlexMasterov\EquipTwig\Tests\TestCase;
use Equip\Adr\PayloadInterface;

class PayloadRenderTraitTest extends TestCase
{
    use PayloadRenderTrait;

    public function testPayloadRender()
    {
        // Stab
        $template = $this->template('test.html.twig');
        $output = [
            'body' => 'body',
        ];

        // Execute
        $payload = $this->render($template->name(), $output);

        // Verify
        self::assertInstanceOf(PayloadInterface::class, $payload);
        self::assertEquals($output, $payload->getOutput());
    }
}
