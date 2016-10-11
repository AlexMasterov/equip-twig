<?php

namespace AlexMasterov\EquipTwigTests\Configuration;

use AlexMasterov\EquipTwig\Configuration\TwigResponderConfiguration;
use AlexMasterov\EquipTwig\Configuration\TwigExtensionSet;
use AlexMasterov\EquipTwig\Exception\ExtensionException;
use Auryn\Injector;
use Equip\Env;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_Environment;

class TwigExtensionSetTest extends TestCase
{
    public function testThenDebugIsEnabled()
    {
        $config = [
            'TWIG_DEBUG' => true
        ];

        $injector = new Injector();
        $injector->prepare(Env::class, function (Env $env) use ($config) {
            return $env->withValues($config);
        });

        $configuration = $injector->make(TwigResponderConfiguration::class);
        $configuration->apply($injector);
        $configuration = $injector->make(TwigExtensionSet::class);
        $configuration->apply($injector);

        $twig = $injector->make(Twig_Environment::class);

        $this->assertTrue($twig->isDebug());
        $this->assertArrayHasKey('debug', $twig->getExtensions());
        // $this->assertArrayHasKey('Twig_Extension_Debug', $twig->getExtensions());
    }

    public function testThenExtensionIsInvalid()
    {
        $this->expectException(ExtensionException::class);

        new TwigExtensionSet([new \stdClass]);
    }
}
