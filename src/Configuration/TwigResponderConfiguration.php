<?php

namespace AlexMasterov\EquipTwig\Configuration;

use AlexMasterov\EquipTwig\Loader\FilesystemLoader;
use AlexMasterov\EquipTwig\TwigFormatter;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use Equip\Env;
use Equip\Responder\FormattedResponder;
use Twig_Environment;

final class TwigResponderConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    const PREFIX = 'TWIG_';

    /**
     * @param Injector $injector
     */
    public function apply(Injector $injector)
    {
        $env = $this->env;

        $path = $env->getValue('TWIG_TEMPLATES');

        $injector->define(FilesystemLoader::class, [
            ':path'           => $path,
            ':fileExtensions' => $this->fileExtensions($env),
        ]);

        $injector->define(Twig_Environment::class, [
            'loader'   => FilesystemLoader::class,
            ':options' => $this->options($env),
        ]);

        $injector->prepare(FormattedResponder::class, function(FormattedResponder $responder) {
            return $responder->withValue(TwigFormatter::class, 1.0);
        });
    }

    /**
     * @param Env $env
     *
     * @return array
     */
    private function fileExtensions(Env $env)
    {
        $fileExtensions = $env->getValue('TWIG_FILE_EXTENSIONS', 'html.twig,twig');

        return explode(',', $fileExtensions);
    }

    /**
     * @param Env $env
     *
     * @return array
     */
    private function options(Env $env)
    {
       static $options = [
            'debug'               => false,
            'strict_variables'    => false,
            'cache'               => false,
            'auto_reload'         => false,
            'charset'             => 'UTF-8',
            'autoescape'          => 'html',
            'base_template_class' => 'Twig_Template',
            'optimizations'       => -1,
        ];

        foreach ($this->envTwig($env) as $option => $value) {
            list(, $option) = explode('_', strtolower($option), 2);
            if (isset($options[$option])) {
                $options[$option] = $value;
            }
        }

        return $options;
    }

    /**
     * @param Env $env
     *
     * @return array
     */
    private function envTwig(Env $env)
    {
        $twigFilter = static function ($value) {
            return stristr($value, self::PREFIX);
        };

        return array_filter($env->toArray(), $twigFilter, ARRAY_FILTER_USE_KEY);
    }
}
