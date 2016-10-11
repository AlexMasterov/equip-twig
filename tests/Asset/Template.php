<?php

namespace AlexMasterov\EquipTwigTests\Asset;

class Template
{
    const PATH = __DIR__ . '/templates';
    const NAME = 'test.html.twig';

    public static function path()
    {
        return self::PATH;
    }

    public static function name()
    {
        return self::NAME;
    }

    public static function templatePath()
    {
        return realpath(
            self::PATH . DIRECTORY_SEPARATOR . self::NAME
        );
    }

    public static function code()
    {
        return file_get_contents(self::templatePath());
    }
}
