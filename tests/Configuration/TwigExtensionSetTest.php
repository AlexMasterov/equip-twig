<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use Asmaster\EquipTwig\Configuration\TwigExtensionSet;
use Asmaster\EquipTwig\Exception\ExtensionException;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Structure\Set;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_Environment as TwigEnvironment;
use Twig_Extension_Debug as TwigExtensionDebug;

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

    public function testInvalidExtension()
    {
        $this->expectException(ExtensionException::class);

        new TwigExtensionSet([new \stdClass]);
    }
}
