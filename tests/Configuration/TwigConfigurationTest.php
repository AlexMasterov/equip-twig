<?php

namespace Asmaster\EquipTwigTests\Configuration;

use Auryn\Injector;
use Equip\Configuration\AurynConfiguration;
use Equip\Responder\FormattedResponder;
use Asmaster\EquipTwig\TwigFormatter;
use Asmaster\EquipTwig\Configuration\TwigConfiguration;

class TwigConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testApply()
    {
        $injector = new Injector;

        foreach ($this->getConfigurations() as $config) {
            $instance = $injector->make($config);
            $instance->apply($injector);
        }

        $responder = $injector->make(FormattedResponder::class);

        $this->assertArrayHasKey(TwigFormatter::class, $responder);
        $this->assertSame(1.0, $responder[TwigFormatter::class]);
    }

    protected function getConfigurations()
    {
        return [
            AurynConfiguration::class,
            TwigConfiguration::class
        ];
    }
}
