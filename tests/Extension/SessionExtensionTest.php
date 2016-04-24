<?php

namespace Asmaster\EquipTwig\Tests\Extension;

use PHPUnit_Framework_TestCase as TestCase;
use Asmaster\EquipTwig\Extension\SessionExtension;
use Equip\SessionInterface;
use Twig_ExtensionInterface as TwigExtensionInterface;

class SessionExtensionTest extends TestCase
{
    public function testExtension()
    {
        $session = $this->getMock(SessionInterface::class);
        $extension = new SessionExtension($session);

        $this->assertInstanceOf(TwigExtensionInterface::class, $extension);
        $this->assertSame('equip_session', $extension->getName());
        
        $this->assertArrayHasKey('session', $extension->getGlobals());
        $this->assertInstanceOf(SessionInterface::class, $extension->getGlobals()['session']);
    }
}
