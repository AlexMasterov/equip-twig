<?php

namespace Asmaster\EquipTwigTests\Configuration;

use Asmaster\EquipTwig\Configuration\TwigDefaultExtension;
use Asmaster\EquipTwig\Extension\RequestExtension;
use Asmaster\EquipTwig\Extension\SessionExtension;

class TwigDefaultExtensionTest extends \PHPUnit_Framework_TestCase 
{
    public function testDefaultExtension()
    {
        $defaults = [
            RequestExtension::class
        ];

        if (interface_exists('Equip\SessionInterface')) {
            $defaults[] = SessionExtension::class;
        }

        $defaultExtension = new TwigDefaultExtension();

        $this->assertSame($defaults, $defaultExtension->toArray());
    }
}
