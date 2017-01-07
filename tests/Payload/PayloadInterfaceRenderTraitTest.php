<?php

namespace AlexMasterov\EquipTwig\Tests\Payload;

use AlexMasterov\EquipTwig\Payload\PayloadInterfaceRenderTrait;
use AlexMasterov\EquipTwig\Tests\TestCase;
use Equip\Adr\PayloadInterface;
use Equip\Payload;

class PayloadInterfaceRenderTraitTest extends TestCase
{
    use PayloadInterfaceRenderTrait;

    protected function setUp()
    {
        $this->payload = new Payload;
    }

    public function testPayloadInterfaceRender()
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
