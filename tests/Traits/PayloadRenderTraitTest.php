<?php

namespace Asmaster\EquipTwig\Tests\Traits;

use PHPUnit_Framework_TestCase as TestCase;
use Equip\Adr\PayloadInterface;
use Asmaster\EquipTwig\Traits\PayloadRenderTrait;

class PayloadRenderTraitTest extends TestCase
{
    use PayloadRenderTrait;

    public function testPayload()
    {
        $this->assertInstanceOf(PayloadInterface::class, $this->payload());
    }

    public function testPayloadRender()
    {
        $output = [
            'template' => 'index.html.twig',
            ['body' => 'body']
        ];

        $payload = $this->render($output['template'], $output);
        $this->assertEquals($output, $payload->getOutput());
    }
}
