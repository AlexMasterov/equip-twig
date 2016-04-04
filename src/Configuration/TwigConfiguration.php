<?php

namespace Asmaster\EquipTwig\Configuration;

use Auryn\Injector;
use Equip\Adr\PayloadInterface;
use Equip\Configuration\EnvTrait;
use Equip\Configuration\ConfigurationInterface;
use Equip\Responder\FormattedResponder;
use Asmaster\EquipTwig\TwigFormatter;
use Asmaster\EquipTwig\TemplatePayload;

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

        $injector->prepare(PayloadInterface::class, function () {
            return new TemplatePayload();
        });

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
        $templates = $this->getRootDir() . DIRECTORY_SEPARATOR . $this->env->getValue('TWIG_TEMPLATES');

        $loader->addPath($templates);
    }

    /**
     * @return array $options
     */
    public function prepareOptions()
    {
        $env = $this->env;

        if ($cacheDir = $env->getValue('TWIG_CACHE')) {
            $cacheDir = $this->getRootDir() . DIRECTORY_SEPARATOR . $env->getValue('TWIG_CACHE');
        }

        $options = [
            'debug'            => $env->getValue('TWIG_DEBUG') ?: false,
            'auto_reload'      => $env->getValue('TWIG_AUTO_RELOAD') ?: true,
            'strict_variables' => $env->getValue('TWIG_STRICT_VARIABLES') ?: false,
            'cache'            => $cacheDir
        ];

        return $options;
    }

    /**
     * @return string $rootDir
     */
    protected function getRootDir()
    {
        // TODO: PHP7 dirname(__DIR__, 5)
        $rootDir = dirname(dirname(dirname(dirname(dirname(__DIR__)))));

        return $rootDir;
    }
}
