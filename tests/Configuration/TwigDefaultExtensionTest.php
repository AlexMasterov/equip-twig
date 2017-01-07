<?php

namespace AlexMasterov\EquipTwig\Tests\Configuration;

use AlexMasterov\EquipTwig\Configuration\TwigDefaultExtension;
use AlexMasterov\EquipTwig\Extension\SessionExtension;
use AlexMasterov\EquipTwig\Tests\Asset\EmptyInterface;
use Equip\SessionInterface;
use PHPUnit_Framework_TestCase as TestCase;

class TwigDefaultExtensionTest extends TestCase
{
    protected function setUp()
    {
        if (!interface_exists(SessionInterface::class)) {
            class_alias(
                EmptyInterface::class,
                SessionInterface::class
            );
        }
    }

    public function testDefaultExtension()
    {
        $defaults = [
            SessionExtension::class
        ];

        $extensions = new TwigDefaultExtension();

        $this->assertSame($defaults, $extensions->toArray());
    }
}
