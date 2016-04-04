<?php

namespace Asmaster\EquipTwigTests\Extension;

use Equip\SessionInterface;
use Asmaster\EquipTwig\Extension\Session;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function testAddExtension()
    {
        $session = $this->getMock(SessionInterface::class);
        $extenstion = new Session($session);

        $loader = $this->getMock('\Twig_LoaderInterface');

        $twig = new \Twig_Environment($loader);
        $twig->addExtension($extenstion);

        $this->assertArrayHasKey('session', $twig->getExtensions());
        $this->assertArrayHasKey('session', $twig->getGlobals());
    }
}
