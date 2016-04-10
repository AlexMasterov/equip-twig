<?php

namespace Asmaster\EquipTwig\Tests;

use Asmaster\EquipTwig\TwigFormatter;
use Asmaster\EquipTwig\TemplatePayload;
use Lukasoppermann\Httpstatus\Httpstatus;

class TwigFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TwigFormatter
     */
    protected $formatter;

    public function setUp()
    {
        if (!class_exists('\Twig_Environment')) {
            $this->markTestSkipped('Twig is not installed');
        }

        $loader = new \Twig_Loader_Filesystem(__DIR__.'/_templates');
        $twig = new \Twig_Environment($loader);

        $this->formatter = new TwigFormatter($twig, new HttpStatus);
    }

    public function testAccepts()
    {
        $this->assertEquals(['text/html'], TwigFormatter::accepts());
    }

    public function testType()
    {
        $this->assertEquals('text/html', $this->formatter->type());
    }

    public function testResponse()
    {
        $payload = (new TemplatePayload)
            ->withOutput([
                'header' => 'header',
                'body'   => 'body',
                'footer' => 'footer',
            ])->withTemplate('index.html.twig');

        $body = (string) $this->formatter->body($payload);
        $this->assertEquals("<h1>header</h1>\n<p>body</p>\n<span>footer</span>\n", $body);
    }
}
