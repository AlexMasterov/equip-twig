<?php

namespace AlexMasterov\EquipTwig\Tests\Exception;

use AlexMasterov\EquipTwig\Exception\ExceptionInterface;
use AlexMasterov\EquipTwig\Exception\ExtensionException;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_ExtensionInterface as TwigExtensionInterface;
use stdClass;

class ExtensionExceptionTest extends TestCase
{
    public function testInvalidExtension()
    {
        $extension = new stdClass;
        $interface = TwigExtensionInterface::class;

        $exception = ExtensionException::invalidClass($extension);

        $this->assertInstanceOf(ExtensionException::class, $exception);
        $this->assertInstanceOf(InvalidArgumentException::class, $exception);
        $this->assertInstanceOf(ExceptionInterface::class, $exception);
        $this->assertSame(
            'Twig extension `'. get_class($extension) .'` must implement `'. $interface .'`',
            $exception->getMessage()
        );
    }
}
