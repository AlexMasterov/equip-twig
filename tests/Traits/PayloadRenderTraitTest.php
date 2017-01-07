<?php

namespace AlexMasterov\EquipTwig\Tests\Traits;

use AlexMasterov\EquipTwig\Traits\PayloadRenderTrait;
use Equip\Adr\PayloadInterface;
use PHPUnit_Framework_TestCase as TestCase;

class PayloadRenderTraitTest extends TestCase
{
    use PayloadRenderTrait;

    public function testPayload()
    {
        $this->assertInstanceOf(PayloadInterface::class, $this->payload());
    }

    public function testPayloadRender()
    {
        $template = 'test.html.twig';
        $output = [
            'body' => 'body'
        ];

        $payload = $this->render($template, $output);

        $this->assertEquals(compact('template') + $output, $payload->getOutput());
    }
}
