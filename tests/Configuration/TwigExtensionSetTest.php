<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use PHPUnit_Framework_TestCase as TestCase;
use Auryn\Injector;
use Equip\Structure\Set;
use Equip\Configuration\ConfigurationInterface;
use Asmaster\EquipTwig\Configuration\TwigExtensionSet;
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

        $extensionSet = new TwigExtensionSet([TwigExtensionDebug::class]);
        $extensionSet->apply($injector);

        $twig = $injector->make(TwigEnvironment::class);
        $this->assertArrayHasKey('debug', $twig->getExtensions());
    }

    /**
     * @expectedException \Asmaster\EquipTwig\Exception\ExtensionException
     * @expectedExceptionRegExp /Twig extension *. must implement Twig_ExtensionInterface/i
     */
    public function testInvalidExtension()
    {
        new TwigExtensionSet([new \stdClass]);
    }
}
