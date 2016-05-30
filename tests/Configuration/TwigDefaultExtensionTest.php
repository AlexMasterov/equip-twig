<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use Asmaster\EquipTwig\Configuration\TwigDefaultExtension;
use Asmaster\EquipTwig\Configuration\TwigExtensionSet;
use Asmaster\EquipTwig\Extension\SessionExtension;
use Asmaster\EquipTwig\Tests\Asset\EmptyInterface;
use Equip\Configuration\ConfigurationInterface;
use Equip\SessionInterface;
use Equip\Structure\Set;
use PHPUnit_Framework_TestCase as TestCase;

class TwigDefaultExtensionTest extends TestCase
{
    public function testDefaultExtension()
    {
        $this->defineInterface(SessionInterface::class);

        $defaults = [
            SessionExtension::class
        ];

        $extensions = new TwigDefaultExtension();

        $this->assertSame($defaults, $extensions->toArray());
        $this->assertInstanceOf(TwigDefaultExtension::class, $extensions);
        $this->assertInstanceOf(TwigExtensionSet::class, $extensions);
        $this->assertInstanceOf(Set::class, $extensions);
        $this->assertInstanceOf(ConfigurationInterface::class, $extensions);
    }

    protected function defineInterface($interface)
    {
        if (!interface_exists($interface)) {
            class_alias(EmptyInterface::class, $interface);
        }
    }
}
