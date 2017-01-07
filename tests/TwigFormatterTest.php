<?php

namespace AlexMasterov\EquipTwig\Tests;

use AlexMasterov\EquipTwig\Tests\TestCase;
use AlexMasterov\EquipTwig\TwigFormatter;
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
        $this->formatter = new TwigFormatter($this->twig());
    }

    public function testAccepts()
    {
        self::assertSame(['text/html'], TwigFormatter::accepts());
    }

    public function testType()
    {
        self::assertSame('text/html', $this->formatter->type());
    }

    public function testResponse()
    {
        // Stab
        $template = $this->template('test.html.twig');
        $content = [
            'header' => 'header',
            'body'   => 'body',
            'footer' => 'footer'
        ];

        // Execute
        $body = $this->formatter
            ->withTemplate($template->name())
            ->format($content)
            ;

        // Verify
        self::assertSame(
            "<h1>header</h1>\n<p>body</p>\n<span>footer</span>\n",
            $body
        );
    }
}
