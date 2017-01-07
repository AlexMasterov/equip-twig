<?php

namespace AlexMasterov\EquipTwig\Tests\Exception;

use AlexMasterov\EquipTwig\Exception\ExtensionException;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase as TestCase;

class ExtensionExceptionTest extends TestCase
{
    public function testInvalidExtension()
    {
        $exception = ExtensionException::invalidExtension(new \stdClass());

        $this->assertInstanceOf(ExtensionException::class, $exception);
        $this->assertInstanceOf(InvalidArgumentException::class, $exception);
        $this->assertSame(
            'Twig extension `stdClass` must implement `Twig_ExtensionInterface`',
            $exception->getMessage()
        );
    }
}
