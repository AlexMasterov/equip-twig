<?php

namespace AlexMasterov\EquipTwigTests;

use AlexMasterov\EquipTwigTests\Asset\Template;
use AlexMasterov\EquipTwig\TwigFormatter;
use PHPUnit_Framework_TestCase as TestCase;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigFormatterTest extends TestCase
{
    /**
     * @var TwigFormatter
     */
    private $formatter;

    protected function setUp()
    {
        $this->formatter = new TwigFormatter(
            new Twig_Environment(
                new Twig_Loader_Filesystem(Template::path())
            )
        );
    }

    public function testAccepts()
    {
        $this->assertSame(['text/html'], TwigFormatter::accepts());
    }

    public function testType()
    {
        $this->assertSame('text/html', $this->formatter->type());
    }

    public function testResponse()
    {
        $content = [
            'header' => 'header',
            'body'   => 'body',
            'footer' => 'footer'
        ];

        $payload = $this->formatter
            ->withTemplate(Template::name())
            ->format($content)
            ;

        $this->assertSame(
            "<h1>header</h1>\n<p>body</p>\n<span>footer</span>\n",
            $payload
        );
    }
}
