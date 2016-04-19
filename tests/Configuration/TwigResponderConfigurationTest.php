<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use PHPUnit_Framework_TestCase as TestCase;
use Auryn\Injector;
use Equip\Configuration\AurynConfiguration;
use Equip\Responder\FormattedResponder;
use Asmaster\EquipTwig\TwigFormatter;
use Asmaster\EquipTwig\Configuration\TwigResponderConfiguration;

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
