<?php

namespace AlexMasterov\EquipTwig\Tests\Extension;

use AlexMasterov\EquipTwig\Extension\SessionExtension;
use Equip\SessionInterface;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_ExtensionInterface;

class SessionExtensionTest extends TestCase
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
