<?php

namespace AlexMasterov\EquipTwigTests\Configuration;

use AlexMasterov\EquipTwig\Configuration\TwigConfiguration;
use Auryn\Injector;
use Equip\Env;
use PHPUnit_Framework_TestCase as TestCase;

class TwigConfigurationTest extends TestCase
{
    public function testApply()
    {
        $config = [
            'TWIG_FILE_EXTENSIONS' => 'html.twig,twig'
        ];

        $injector = new Injector;
        $injector->prepare(Env::class, function (Env $env) use ($config) {
            return $env->withValues($config);
        });

        $configuration = $injector->make(TwigConfiguration::class);
        $configuration->apply($injector);
    }
}
