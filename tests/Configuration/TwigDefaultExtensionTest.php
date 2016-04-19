<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use PHPUnit_Framework_TestCase;
use Equip\SessionInterface;
use Asmaster\EquipTwig\Tests\Asset\EmptyInterface;
use Asmaster\EquipTwig\Configuration\TwigDefaultExtension;
use Asmaster\EquipTwig\Extension\SessionExtension;

class TwigDefaultExtensionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
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
