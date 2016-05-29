<?php

namespace Asmaster\EquipTwig\Tests\Exception;

use Asmaster\EquipTwig\Exception\LoaderException;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_Error_Loader as TwigErrorLoader;

class LoaderExceptionTest extends TestCase
{
    public function testLoaderException()
    {
        $exception = LoaderException::notFound('test', '/templates');

        $this->assertInstanceOf(LoaderException::class, $exception);
        $this->assertInstanceOf(TwigErrorLoader::class, $exception);
        $this->assertSame(
            'Unable to find template `test` (looked into: /templates).',
            $exception->getMessage()
        );
    }
}
