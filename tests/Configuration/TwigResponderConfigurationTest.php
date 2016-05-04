<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use Auryn\Injector;
use Asmaster\EquipTwig\TwigFormatter;
use Asmaster\EquipTwig\Configuration\TwigResponderConfiguration;
use Equip\Configuration\AurynConfiguration;
use Equip\Responder\FormattedResponder;
use PHPUnit_Framework_TestCase as TestCase;

class TwigResponderConfigurationTest extends TestCase
{
    public function testApply()
    {
        $injector = new Injector;

        $auryn = new AurynConfiguration();
        $auryn->apply($injector);

        $config = $injector->make(TwigResponderConfiguration::class);
        $config->apply($injector);

        $responder = $injector->make(FormattedResponder::class);

        $this->assertArrayHasKey(TwigFormatter::class, $responder);
        $this->assertSame(1.0, $responder[TwigFormatter::class]);
    }
}
