<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use Asmaster\EquipTwig\Configuration\TwigResponderConfiguration;
use Asmaster\EquipTwig\TwigFormatter;
use Auryn\Injector;
use Equip\Configuration\AurynConfiguration;
use Equip\Env;
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

    public function testEnvironmentVariables()
    {
        $envVariables = [
            'TWIG_FILE_EXTENSIONS' => 'html.twig,twig'
        ];

        $injector = new Injector;
        $injector->prepare(Env::class, function (Env $env) use ($envVariables) {
            return $env->withValues($envVariables);
        });

        $config = $injector->make(TwigResponderConfiguration::class);
        $config->apply($injector);
    }
}
