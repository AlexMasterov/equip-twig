<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use PHPUnit_Framework_TestCase as TestCase;
use Auryn\Injector;
use Equip\Structure\Set;
use Equip\Configuration\ConfigurationInterface;
use Asmaster\EquipTwig\Configuration\TwigExtensionSet;
use Twig_Environment as TwigEnvironment;

class TwigExtensionSetTest extends TestCase 
{
    public function testSet()
    {
        $defaultExtension = new TwigExtensionSet();

        $this->assertInstanceOf(Set::class, $defaultExtension);
        $this->assertInstanceOf(ConfigurationInterface::class, $defaultExtension);
    }

    public function testApply()
    {
        $injector = new Injector();
        $injector->define(TwigEnvironment::class, [
            ':options' => ['debug' => true]
        ]);

        $extensionSet = new TwigExtensionSet();
        $extensionSet->apply($injector);

        $twig = $injector->make(TwigEnvironment::class);
        $this->assertArrayHasKey('debug', $twig->getExtensions());
    }
}
