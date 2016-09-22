<?php

namespace AlexMasterov\EquipTwig\Tests\Traits;

use AlexMasterov\EquipTwig\Traits\PayloadInterfaceRenderTrait;
use Equip\Adr\PayloadInterface;
use Equip\Payload;
use PHPUnit_Framework_TestCase as TestCase;

class PayloadInterfaceRenderTraitTest extends TestCase
{
    use PayloadInterfaceRenderTrait;

    protected function setUp()
    {
        $this->payload = new Payload;
    }

    public function testPayloadInterface()
    {
        $this->assertInstanceOf(PayloadInterface::class, $this->payload);
    }

    public function testPayloadInterfaceRender()
    {
        $template = 'test.html.twig';
        $output = [
            'body' => 'body'
        ];

        $payload = $this->render($template, $output);

        $this->assertEquals($output, $payload->getOutput());
    }
}
