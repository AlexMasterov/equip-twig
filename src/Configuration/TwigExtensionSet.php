<?php

namespace Asmaster\EquipTwig\Configuration;

use Asmaster\EquipTwig\Exception\ExtensionException;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Structure\Set;
use Twig_Environment as TwigEnvironment;
use Twig_ExtensionInterface as TwigExtensionInterface;
use Twig_Extension_Debug as TwigExtensionDebug;

class TwigExtensionSet extends Set implements ConfigurationInterface
{
    /**
     * @param Injector $injector
     */
    public function apply(Injector $injector)
    {
        $injector->prepare(TwigEnvironment::class, [$this, 'prepareExtension']);
    }

    /**
     * @param TwigEnvironment  $environment
     * @param Injector         $injector
     *
     * @return void
     */
    public function prepareExtension(TwigEnvironment $environment, Injector $injector)
    {
        $extensions = $this->toArray();

        if ($environment->isDebug()) {
            $extensions[] = TwigExtensionDebug::class;
        }

        foreach ($extensions as $extension) {
            if (!is_object($extension)) {
                $extension = $injector->make($extension);
            }

            $environment->addExtension($extension);
        }
    }

    /**
     * @param array $extensions
     *
     * @throws ExtensionException::invalidExtension
     */
    protected function assertValid(array $extensions)
    {
        parent::assertValid($extensions);

        foreach ($extensions as $extension) {
            if (!is_subclass_of($extension, TwigExtensionInterface::class)) {
                throw ExtensionException::invalidExtension($extension);
            }
        }
    }
}
