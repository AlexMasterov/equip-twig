<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use PHPUnit_Framework_TestCase;
use Asmaster\EquipTwig\Configuration\TwigDefaultExtension;
use Asmaster\EquipTwig\Extension\SessionExtension;

class TwigDefaultExtensionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!interface_exists('Equip\SessionInterface')) {
            class_alias(
                'Asmaster\EquipTwig\Tests\Fake\FakeInterface',
                'Equip\SessionInterface'
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
