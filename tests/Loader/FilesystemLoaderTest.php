<?php

namespace Asmaster\EquipTwig\Tests\Loader;

use Asmaster\EquipTwig\Exception\LoaderException;
use Asmaster\EquipTwig\Loader\FilesystemLoader;
use PHPUnit_Framework_TestCase as TestCase;

class FilesystemLoaderTest extends TestCase
{
    public function testEmptyConstructor()
    {
        $path = '/templates';
        $fileExtensions = ['html.twig'];

        $loader = new FilesystemLoader(
            $path,
            $fileExtensions
        );

        $this->assertEquals($path, $loader->getPath());
        $this->assertEquals($fileExtensions, $loader->getFileExtensions());
    }

    public function testGetSource()
    {
        $path = __DIR__.'/../Asset/templates';
        $template = 'sugar.html.twig';

        $loader = new FilesystemLoader($path);
        $source = $loader->getSource($template);

        $this->assertEquals("sugar\n", $source);
    }

    public function testGetCacheKey()
    {
        $template = 'sugar.html.twig';

        $path = __DIR__.'/../Asset/templates';
        $realPath = realpath($path . DIRECTORY_SEPARATOR . $template);

        $loader = new FilesystemLoader($path);
        $cacheKey = $loader->getCacheKey($template);
        $source = $loader->getSource($template);

        $this->assertEquals($realPath, $cacheKey);
    }

    public function testIsFresh()
    {
        $template = 'sugar.html.twig';
        $path = __DIR__.'/../Asset/templates';

        $loader = new FilesystemLoader($path);

        $this->assertTrue($loader->isFresh($template, time()));
    }

    public function testExists()
    {
        $template = 'sugar.html.twig';
        $path = __DIR__.'/../Asset/templates';

        $loader = new FilesystemLoader($path);
        $exists = $loader->exists($template);

        $this->assertTrue($exists);

        $loader = new FilesystemLoader($path);
        $source = $loader->getSource($template);
        $exists = $loader->exists($template);

        $this->assertTrue($exists);
    }

    public function testFindTemplateException()
    {
        $this->expectException(LoaderException::class);

        $loader = new FilesystemLoader('/templates');
        $loader->getSource('nowhere.html.twig');
    }
}
