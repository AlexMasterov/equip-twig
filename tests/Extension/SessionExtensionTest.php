<?php

namespace Asmaster\EquipTwig\Tests\Extension;

use Asmaster\EquipTwig\Extension\SessionExtension;
use Equip\SessionInterface;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_ExtensionInterface as TwigExtensionInterface;

class SessionExtensionTest extends TestCase
{
    public function testExtension()
    {
        $extension = new SessionExtension(
            $this->createMock(SessionInterface::class)
        );

        $this->assertSame('equip_session', $extension->getName());
        $this->assertInstanceOf(TwigExtensionInterface::class, $extension);

        $this->assertArrayHasKey('session', $extension->getGlobals());
        $this->assertInstanceOf(SessionInterface::class, $extension->getGlobals()['session']);
    }
}
