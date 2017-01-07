<?php

namespace AlexMasterov\EquipTwig\Tests;

use AlexMasterov\EquipTwig\TwigFormatter;
use Equip\Adr\PayloadInterface;
use Lukasoppermann\Httpstatus\Httpstatus;
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
        $loader = new Twig_Loader_Filesystem(__DIR__.'/Asset/templates');

        $this->formatter = new TwigFormatter(
            new Twig_Environment($loader),
            new HttpStatus
        );
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
        $output = [
            'template' => 'test.html.twig',
            'header'   => 'header',
            'body'     => 'body',
            'footer'   => 'footer'
        ];

        $payload = $this->getMock(PayloadInterface::class);

        $payload
            ->expects($this->any())
            ->method('getOutput')
            ->will($this->returnValue($output));

        $body = $this->formatter->body($payload);

        $this->assertEquals("<h1>header</h1>\n<p>body</p>\n<span>footer</span>\n", $body);
    }
}
