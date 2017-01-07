<?php

namespace AlexMasterov\EquipTwig\Tests\Loader;

use AlexMasterov\EquipTwig\Exception\LoaderException;
use AlexMasterov\EquipTwig\Loader\FilesystemLoader;
use AlexMasterov\EquipTwig\Tests\TestCase;
use Twig_Source;

class FilesystemLoaderTest extends TestCase
{
    public function testGetSourceContext()
    {
        // Stab
        $template = $this->template('test.html.twig');

        // Execute
        $loader = new FilesystemLoader($template->path());
        $source = $loader->getSourceContext($template->name());

        // Verify
        self::assertInstanceOf(Twig_Source::class, $source);
        self::assertSame($template->name(), $source->getName());
        self::assertSame($template->code(), $source->getCode());
    }

    public function testGetCacheKey()
    {
        // Stab
        $template = $this->template('test.html.twig');

        // Execute
        $loader = new FilesystemLoader($template->path());
        $loader->getSourceContext($template->name());

        $cacheKey = $loader->getCacheKey($template->name());

        // Verify
        self::assertSame(realpath($template->templatePath()), $cacheKey);
    }

    public function testIsFresh()
    {
        // Stab
        $template = $this->template('test.html.twig');

        // Execute
        $loader = new FilesystemLoader($template->path());

        // Verify
        self::assertTrue(
            $loader->isFresh($template->name(), time())
        );
    }

    public function testExists()
    {
        // Stab
        $template = $this->template('test.html.twig');
        $ext = 'html.twig';

        // Execute
        $loader = new FilesystemLoader($template->path(), [$ext]);

        // Verify
        self::assertTrue($loader->exists($template->name()));

        // Execute (with cached)
        $loader->getSourceContext($template->name());

        // Verify
        self::assertTrue($loader->exists($template->name()));

        // Execute (without .ext)
        $loader->getSourceContext(
            basename($template->name(), ".{$ext}")
        );

        // Verify
        self::assertTrue($loader->exists($template->name()));
    }

    public function testThenTemplateNotFound()
    {
        // Verify
        self::expectException(LoaderException::class);

        // Stab
        $template = $this->template('test.html.twig');

        // Execute
        $loader = new FilesystemLoader($template->path());
        $loader->getSourceContext('nowhere.html.twig');
    }
}
