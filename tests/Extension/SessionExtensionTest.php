<?php

namespace Asmaster\EquipTwig\Tests\Extension;

use PHPUnit_Framework_TestCase;
use Equip\SessionInterface;
use Twig_ExtensionInterface;
use Asmaster\EquipTwig\Extension\SessionExtension;

class SessionExtensionTest extends PHPUnit_Framework_TestCase
{
    public function testExtension()
    {
        $session = $this->getMock(SessionInterface::class);
        $extension = new SessionExtension($session);

        $this->assertInstanceOf(Twig_ExtensionInterface::class, $extension);
        $this->assertSame('equip_session', $extension->getName());
        
        $this->assertArrayHasKey('session', $extension->getGlobals());
        $this->assertInstanceOf(SessionInterface::class, $extension->getGlobals()['session']);
    }
}
