<?php

namespace Asmaster\EquipTwig\Configuration;

use Auryn\Injector;
use Equip\Configuration\EnvTrait;
use Equip\Configuration\ConfigurationInterface;
use Equip\Responder\FormattedResponder;
use Asmaster\EquipTwig\TwigFormatter;
use Twig_Loader_Filesystem;
use Twig_Environment;

class TwigResponderConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    /**
     * @param Injector $injector
     */
    public function apply(Injector $injector)
    {
        $injector->prepare(FormattedResponder::class, function (FormattedResponder $responder) {
            return $responder->withValue(TwigFormatter::class, 1.0);
        });

        $injector->define(Twig_Loader_Filesystem::class, [
            ':paths' => $this->env->getValue('TWIG_TEMPLATES')
        ]);

        $injector->define(Twig_Environment::class, [
            'loader'   => Twig_Loader_Filesystem::class,
            ':options' => $this->getOptions()
        ]);
    }

    /**
     * @return array $options
     */
    public function getOptions()
    {
        $env = $this->env;

        $options = [
            'debug'            => $env->getValue('TWIG_DEBUG') ?: false,
            'auto_reload'      => $env->getValue('TWIG_AUTO_RELOAD') ?: true,
            'strict_variables' => $env->getValue('TWIG_STRICT_VARIABLES') ?: false,
            'cache'            => $env->getValue('TWIG_CACHE') ?: false
        ];

        return $options;
    }
}
