<?php

namespace AlexMasterov\EquipTwig\Configuration;

use AlexMasterov\EquipTwig\Loader\FilesystemLoader;
use AlexMasterov\EquipTwig\TwigFormatter;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use Equip\Env;
use Twig_Environment;

final class TwigConfiguration implements ConfigurationInterface
{
    use EnvTrait;

    /**
     * @param Injector $injector
     */
    public function apply(Injector $injector)
    {
        $env = $this->env;
        $options = $this->options($env);

        $injector->define(Twig_Environment::class, [
            'loader'   => FilesystemLoader::class,
            ':options' => $options
        ]);

        list($path,$fileExtensions) = $this->filesystemConfig($env);

        $injector->define(FilesystemLoader::class, [
            ':path'           => $path,
            ':fileExtensions' => $fileExtensions
        ]);
    }

    /**
     * @param Env $env
     *
     * @return array Configuration options from environment variables
     */
    private function options(Env $env)
    {
        $options = [
            'debug'            => $env->getValue('TWIG_DEBUG', false),
            'auto_reload'      => $env->getValue('TWIG_AUTO_RELOAD', true),
            'strict_variables' => $env->getValue('TWIG_STRICT_VARIABLES', false),
            'cache'            => $env->getValue('TWIG_CACHE', false)
        ];

        return $options;
    }

    /**
     * @param Env $env
     *
     * @return array
     */
    private function filesystemConfig(Env $env)
    {
        $path = $env->getValue('TWIG_TEMPLATES');
        $fileExtensions = $env->getValue('TWIG_FILE_EXTENSIONS', ['html.twig', 'twig']);

        if (is_string($fileExtensions)) {
            $fileExtensions = explode(',', $fileExtensions);
        }

        return [$path, $fileExtensions];
    }
}
