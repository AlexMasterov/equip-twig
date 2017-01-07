<?php

namespace AlexMasterov\EquipTwig\Tests\Configuration;

use AlexMasterov\EquipTwig\Configuration\TwigConfiguration;
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
        // Stab
        $config = [
            'TWIG_DEBUG' => true,
            'TWIG_TEMPLATES' => __DIR__
        ];

        $injector = new Injector();
        $injector->prepare(Env::class, function (Env $env) use ($config) {
            return $env->withValues($config);
        });

        $configuration = $injector->make(TwigConfiguration::class);
        $configuration->apply($injector);
        $configuration = $injector->make(TwigExtensionSet::class);
        $configuration->apply($injector);

        // Execute
        $twig = $injector->make(Twig_Environment::class);

        // Verify
        self::assertTrue($twig->isDebug());
    }

    public function testThenExtensionIsInvalid()
    {
        // Verify
        self::expectException(ExtensionException::class);

        // Execute
        new TwigExtensionSet([new \stdClass]);
    }
}
