<?php

namespace AlexMasterov\EquipTwig\Configuration;

use AlexMasterov\EquipTwig\Exception\ExtensionException;
use Auryn\Injector;
use Equip\Configuration\ConfigurationInterface;
use Equip\Structure\Set;
use Twig_Environment;
use Twig_ExtensionInterface;
use Twig_Extension_Debug;

class TwigExtensionSet extends Set implements ConfigurationInterface
{
    /**
     * @param Injector $injector
     */
    public function apply(Injector $injector)
    {
        $injector->prepare(Twig_Environment::class, [$this, 'prepareExtension']);
    }

    /**
     * @param TwigEnvironment  $environment
     * @param Injector         $injector
     *
     * @return void
     */
    public function prepareExtension(
        Twig_Environment $environment,
        Injector $injector
    ) {
        $extensions = $this->toArray();

        if ($environment->isDebug()) {
            $extensions[] = Twig_Extension_Debug::class;
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
            if (!is_subclass_of($extension, Twig_ExtensionInterface::class)) {
                throw ExtensionException::invalidExtension($extension);
            }
        }
    }
}
