<?php

namespace Asmaster\EquipTwigtests\Configuration;

use Asmaster\EquipTwig\Configuration\TwigDefaultExtension;
use Asmaster\EquipTwig\Extension\RequestExtension;
use Asmaster\EquipTwig\Extension\SessionExtension;

class TwigDefaultExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (! interface_exists('Equip\SessionInterface')) {
            class_alias(
                'Asmaster\EquipTwigTests\Fake\FakeInterface',
                'Equip\SessionInterface'
            );
        }
    }

    public function testDefaultExtension()
    {
        $defaults = [
            RequestExtension::class,
            SessionExtension::class
        ];

        $extensions = new TwigDefaultExtension();

        $this->assertSame($defaults, $extensions->toArray());
    }
}
