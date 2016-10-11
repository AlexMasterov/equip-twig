<?php

namespace AlexMasterov\EquipTwigTests\Traits;

use AlexMasterov\EquipTwigTests\Asset\Template;
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
        $output = [
            'body' => 'body'
        ];

        $payload = $this->render(Template::name(), $output);

        $this->assertSame($output, $payload->getOutput());
    }
}
