<?php

namespace Asmaster\EquipTwig\Tests;

use PHPUnit_Framework_TestCase as TestCase;
use Equip\Adr\PayloadInterface;
use Asmaster\EquipTwig\TwigFormatter;
use Lukasoppermann\Httpstatus\Httpstatus;
use Twig_Loader_Filesystem;
use Twig_Environment;

class TwigFormatterTest extends TestCase
{
    /**
     * @var TwigFormatter
     */
    protected $formatter;

    public function setUp()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/Asset/templates');
        $twig = new Twig_Environment($loader);

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
        $output = [
            'template' => 'index.html.twig',
            'header'   => 'header',
            'body'     => 'body',
            'footer'   => 'footer'
        ];

        /** @var PayloadInterface|\PHPUnit_Framework_MockObject_MockObject */
        $payload = $this->getMock(PayloadInterface::class);
        $payload
            ->expects($this->any())
            ->method('getOutput')
            ->will($this->returnValue($output));

        $body = (string) $this->formatter->body($payload);
        $this->assertEquals("<h1>header</h1>\n<p>body</p>\n<span>footer</span>\n", $body);
    }
}
