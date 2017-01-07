<?php

namespace AlexMasterov\EquipTwig\Tests\Exception;

use AlexMasterov\EquipTwig\Exception\ExceptionInterface;
use AlexMasterov\EquipTwig\Exception\ExtensionException;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_ExtensionInterface;

class ExtensionExceptionTest extends TestCase
{
    public function testInvalidExtension()
    {
        // Stab
        $extension = new \stdClass;
        $message = sprintf(
            'Twig extension `%s` must implement `%s`' ,
            get_class($extension),
            Twig_ExtensionInterface::class
        );

        // Execute
        $exception = ExtensionException::invalidClass($extension);

        // Verify
        self::assertInstanceOf(ExtensionException::class, $exception);
        self::assertInstanceOf(InvalidArgumentException::class, $exception);
        self::assertInstanceOf(ExceptionInterface::class, $exception);
        self::assertSame($message, $exception->getMessage());
    }
}
