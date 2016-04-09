<?php

namespace Asmaster\EquipTwig\Configuration;

use Auryn\Injector;
use Equip\Configuration\EnvTrait;
use Equip\Configuration\ConfigurationInterface;
use Equip\Responder\FormattedResponder;
use Asmaster\EquipTwig\TwigFormatter;

class TwigConfiguration implements ConfigurationInterface
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

        $injector->alias(
            'Equip\Adr\PayloadInterface',
            'Asmaster\EquipTwig\TemplatePayload'
        );

        $injector->prepare(\Twig_Loader_Filesystem::class, [$this, 'prepareFilesystem']);

        $injector->define(\Twig_Environment::class, [
            'loader'   => \Twig_Loader_Filesystem::class,
            ':options' => $this->prepareOptions()
        ]);
    }

    /**
     * @param Twig_Loader_Filesystem $loader
     */
    public function prepareFilesystem(\Twig_Loader_Filesystem $loader)
    {
        $templates = $this->env->getValue('TWIG_TEMPLATES');

        $loader->addPath($templates);
    }

    /**
     * @return array $options
     */
    public function prepareOptions()
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
