<?php

namespace Asmaster\EquipTwig\Configuration;

use Asmaster\EquipTwig\TwigFormatter;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use Equip\Responder\FormattedResponder;
use Twig_Environment as TwigEnvironment;
use Twig_Loader_Filesystem as TwigLoaderFilesystem;

class TwigResponderConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    /**
     * @param Injector $injector
     */
    public function apply(Injector $injector)
    {
        $injector->prepare(FormattedResponder::class, function(FormattedResponder $responder) {
            return $responder->withValue(TwigFormatter::class, 1.0);
        });

        $injector->define(TwigLoaderFilesystem::class, [
            ':paths' => $this->env->getValue('TWIG_TEMPLATES')
        ]);

        $injector->define(TwigEnvironment::class, [
            ':loader'  => TwigLoaderFilesystem::class,
            ':options' => $this->getEnvOptions()
        ]);
    }

    /**
     * @return array Configuration options from environment variables
     */
    public function getEnvOptions()
    {
        $env = $this->env;

        $options = [
            'debug'            => $env->getValue('TWIG_DEBUG', false),
            'auto_reload'      => $env->getValue('TWIG_AUTO_RELOAD', true),
            'strict_variables' => $env->getValue('TWIG_STRICT_VARIABLES', false),
            'cache'            => $env->getValue('TWIG_CACHE', false)
        ];

        return $options;
    }
}
