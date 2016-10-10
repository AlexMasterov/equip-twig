<?php

namespace AlexMasterov\EquipTwigTests\Loader;

use AlexMasterov\EquipTwigTests\Asset\Template;
use AlexMasterov\EquipTwig\Exception\LoaderException;
use AlexMasterov\EquipTwig\Loader\FilesystemLoader;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_Source;

class FilesystemLoaderTest extends TestCase
{
    public function testConstructor()
    {
        $fileExtensions = ['html.twig'];

        $loader = new FilesystemLoader(
            Template::path(),
            $fileExtensions
        );

        $class = new \ReflectionClass($loader);

        // path
        $propPath = $class->getProperty('path');
        $propPath->setAccessible(true);

        $this->assertSame(Template::path(), $propPath->getValue($loader));

        // fileExtensions
        $propFileExtensions = $class->getProperty('fileExtensions');
        $propFileExtensions->setAccessible(true);

        $this->assertEquals($fileExtensions, $propFileExtensions->getValue($loader));
    }

    public function testGetSource()
    {
        $loader = new FilesystemLoader(Template::path());
        $source = $loader->getSource(Template::name());

        $this->assertSame(Template::code(), $source);
    }

    public function testGetSourceContext()
    {
        $loader = new FilesystemLoader(Template::path());
        $source = $loader->getSourceContext(Template::name());

        $this->assertInstanceOf(Twig_Source::class, $source);
        $this->assertSame(Template::name(), $source->getName());
        $this->assertSame(Template::code(), $source->getCode());
    }

    public function testGetCacheKey()
    {
        $loader = new FilesystemLoader(Template::path());
        $loader->getSourceContext(Template::name());

        $cacheKey = $loader->getCacheKey(Template::name());

        $this->assertSame(Template::templatePath(), $cacheKey);
    }

    public function testIsFresh()
    {
        $loader = new FilesystemLoader(Template::path());

        $this->assertTrue(
            $loader->isFresh(Template::name(), time())
        );
    }

    public function testExists()
    {
        $loader = new FilesystemLoader(Template::path(), ['html.twig']);

        $this->assertTrue(
            $loader->exists(Template::name())
        );

        // cached
        $loader->getSourceContext(Template::name());

        $this->assertTrue(
            $loader->exists(Template::name())
        );

        // without .ext
        $name = strstr(Template::name(), '.', true);
        $loader->getSourceContext($name);

        $this->assertTrue(
            $loader->exists($name)
        );
    }

    public function testThenTemplateNotFound()
    {
        $this->expectException(LoaderException::class);

        $loader = new FilesystemLoader(Template::path());
        $loader->getSourceContext('nowhere.html.twig');
    }
}
