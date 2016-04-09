<?php

namespace Asmaster\EquipTwigTests\Configuration;

use Auryn\Injector;
use Equip\Env;
use Equip\Configuration\AurynConfiguration;
use Equip\Responder\FormattedResponder;
use Asmaster\EquipTwig\TwigFormatter;
use Asmaster\EquipTwig\Configuration\TwigConfiguration;

class TwigConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testApply()
    {
        $injector = new Injector;

        foreach ($this->getConfigurations() as $config) {
            $instance = $injector->make($config);
            $instance->apply($injector);
        }

        $responder = $injector->make(FormattedResponder::class);

        $this->assertArrayHasKey(TwigFormatter::class, $responder);
        $this->assertSame(1.0, $responder[TwigFormatter::class]);
    }

    protected function getConfigurations()
    {
        return [
            AurynConfiguration::class,
            TwigConfiguration::class
        ];
    }

    public function testPrepareFilesystem()
    {
        $templatesDir = __DIR__.'/../_templates';

        $injector = new Injector;
        $injector->prepare(Env::class, function (Env $env) use ($templatesDir) {
            return $env->withValue('TWIG_TEMPLATES', $templatesDir);
        });

        $config = $injector->make(TwigConfiguration::class);
        $config->apply($injector);

        $loader = $injector->make(\Twig_Loader_Filesystem::class);

        $this->assertNotEmpty($loader->getPaths());
        $this->assertSame($templatesDir, $loader->getPaths()[0]);
    }
}
