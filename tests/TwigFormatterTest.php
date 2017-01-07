<?php

namespace AlexMasterov\EquipTwig\Tests;

use AlexMasterov\EquipTwig\Tests\TestCase;
use AlexMasterov\EquipTwig\TwigFormatter;
use Equip\Adr\PayloadInterface;

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
        $output = [
            'header' => 'header',
            'body'   => 'body',
            'footer' => 'footer',
        ];

        // Mock
        $payload = self::createMock(PayloadInterface::class);
        $payload->expects(self::any())->method('getOutput')->willReturn($output);
        $payload->expects(self::any())->method('getSetting')->willReturn($template->name());

        // Execute
        $body = $this->formatter->body($payload);

        // Verify
        self::assertSame(
            "<h1>header</h1>\n<p>body</p>\n<span>footer</span>\n",
            $body
        );
    }
}
