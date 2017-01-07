<?php

namespace AlexMasterov\EquipTwig\Tests;

use PHPUnit_Framework_TestCase as BaseTestCase;
use Twig_Environment;
use Twig_Loader_Filesystem;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var string
     */
    protected static $templates = __DIR__ . '/Asset/templates';

    public function twig(): Twig_Environment
    {
        return new Twig_Environment(
            new Twig_Loader_Filesystem(static::$templates)
        );
    }

    public function template(string $name = null)
    {
        return new class (static::$templates, $name) {
            public function __construct($templates, $name)
            {
                $this->templates = $templates;
                $this->name = $name;
            }

            public function path()
            {
                return $this->templates;
            }

            public function name()
            {
                return $this->name;
            }

            public function templatePath()
            {
                return $this->templates . DIRECTORY_SEPARATOR . $this->name;
            }

            public function code()
            {
                return file_get_contents($this->templatePath());
            }
        };
    }
}
