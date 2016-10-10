<?php

namespace AlexMasterov\EquipTwigTests\Exception;

use AlexMasterov\EquipTwig\Exception\ExceptionInterface;
use AlexMasterov\EquipTwig\Exception\ExtensionException;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_ExtensionInterface;
use stdClass;

class ExtensionExceptionTest extends TestCase
{
    public function testInvalidExtension()
    {
        $extension = new stdClass;
        $interface = Twig_ExtensionInterface::class;

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
