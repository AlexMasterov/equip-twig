<?php

namespace Asmaster\EquipTwig\Tests\Exception;

use Asmaster\EquipTwig\Exception\ExceptionInterface;
use Asmaster\EquipTwig\Exception\LoaderException;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_Error_Loader as TwigErrorLoader;

class LoaderExceptionTest extends TestCase
{
    public function testLoaderException()
    {
        $template = 'nowhere';
        $where = __DIR__;

        $exception = LoaderException::notFound($template, $where);

        $this->assertInstanceOf(LoaderException::class, $exception);
        $this->assertInstanceOf(TwigErrorLoader::class, $exception);
        $this->assertInstanceOf(ExceptionInterface::class, $exception);
        $this->assertSame(
            'Unable to find template `'. $template .'` (looked into: '. $where . ').',
            $exception->getMessage()
        );
    }
}
