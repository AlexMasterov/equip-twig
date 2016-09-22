<?php

namespace AlexMasterov\EquipTwig\Configuration;

use AlexMasterov\EquipTwig\Loader\FilesystemLoader;
use AlexMasterov\EquipTwig\TwigFormatter;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Configuration\EnvTrait;
use Equip\Responder\FormattedResponder;
use Twig_Environment;

final class TwigResponderConfiguration implements ConfigurationInterface
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

        $injector->define(FilesystemLoader::class, [
            ':path'           => $this->env->getValue('TWIG_TEMPLATES'),
            ':fileExtensions' => $this->getEnvFileExtensions()
        ]);

        $injector->define(Twig_Environment::class, [
            'loader'   => FilesystemLoader::class,
            ':options' => $this->getEnvOptions()
        ]);
    }

    /**
     * @return array
     */
    public function getEnvFileExtensions()
    {
        $fileExtensions = $this->env->getValue('TWIG_FILE_EXTENSIONS', ['html.twig', 'twig']);

        if (is_string($fileExtensions)) {
            $fileExtensions = explode(',', $fileExtensions);
        }

        return $fileExtensions;
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
