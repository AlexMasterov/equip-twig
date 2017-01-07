<?php

namespace AlexMasterov\EquipTwig\Tests\Exception;

use AlexMasterov\EquipTwig\Exception\ExceptionInterface;
use AlexMasterov\EquipTwig\Exception\LoaderException;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_Error_Loader;

class LoaderExceptionTest extends TestCase
{
    public function testLoaderException()
    {
        // Stab
        $template = 'nowhere';
        $where = __DIR__;
        $message = sprintf(
            'Unable to find template `%s` (looked into: %s).',
            $template,
            $where
        );

        // Execute
        $exception = LoaderException::notFound($template, $where);

        // Verify
        self::assertInstanceOf(LoaderException::class, $exception);
        self::assertInstanceOf(Twig_Error_Loader::class, $exception);
        self::assertInstanceOf(ExceptionInterface::class, $exception);
        self::assertSame($message, $exception->getMessage());
    }
}
