<?php

namespace Asmaster\EquipTwig\Tests;

use Asmaster\EquipTwig\TemplatePayload;

class TemplatePayloadTest extends \PHPUnit_Framework_TestCase
{
    public function testTemplate()
    {
        $template = 'index.html.twig';

        $payload = new TemplatePayload;
        $copy = $payload->withTemplate($template);

        $this->assertNull($payload->getTemplate());
        $this->assertSame($template, $copy->getTemplate());
    }
}
