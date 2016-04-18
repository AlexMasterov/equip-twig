<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use PHPUnit_Framework_TestCase;
use Auryn\Injector;
use Twig_Environment;
use Equip\Structure\Set;
use Equip\Configuration\ConfigurationInterface;
use Asmaster\EquipTwig\Configuration\TwigExtensionSet;

class TwigExtensionSetTest extends PHPUnit_Framework_TestCase 
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
        $injector->define(Twig_Environment::class, [
            ':options' => ['debug' => true]
        ]);

        $extensionSet = new TwigExtensionSet();
        $extensionSet->apply($injector);

        $twig = $injector->make(Twig_Environment::class);
        $this->assertArrayHasKey('debug', $twig->getExtensions());
    }
}
