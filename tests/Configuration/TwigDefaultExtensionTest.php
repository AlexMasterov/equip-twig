<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use Asmaster\EquipTwig\Configuration\TwigDefaultExtension;
use Asmaster\EquipTwig\Extension\SessionExtension;
use Asmaster\EquipTwig\Tests\Asset\EmptyInterface;
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
