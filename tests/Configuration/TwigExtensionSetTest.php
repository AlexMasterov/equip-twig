<?php

namespace Asmaster\EquipTwig\Tests\Configuration;

use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Asmaster\EquipTwig\Configuration\TwigExtensionSet;

class TwigExtensionSetTest extends \PHPUnit_Framework_TestCase 
{
    public function testSet()
    {
        $defaultExtension = new TwigExtensionSet();
        $this->assertEmpty($defaultExtension->toArray());

        $e1 = 'Extension1';
        $e2 = 'Extension2';
        $e3 = 'Extension3';

        $defaultExtension = $defaultExtension->withValue($e1);
        $this->assertContains($e1, $defaultExtension);

        $defaultExtension = $defaultExtension->withValueBefore($e2, $e1);
        $defaultExtension = $defaultExtension->withValueAfter($e3, $e1);

        $this->assertSame([$e2, $e1, $e3], $defaultExtension->toArray());
    }

    public function testApply()
    {
        $injector = new Injector;

        $injector->define(\Twig_Environment::class, [
            ':options' => ['debug' => true]
        ]);

        $extensionSet = new TwigExtensionSet();
        $extensionSet->apply($injector);

        $twig = $injector->make(\Twig_Environment::class);

        $this->assertArrayHasKey('debug', $twig->getExtensions());
    }
}
