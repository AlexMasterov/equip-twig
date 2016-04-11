<?php

namespace Asmaster\EquipTwig\Configuration;

use Auryn\Injector;
use Equip\Structure\Set;
use Equip\Configuration\ConfigurationInterface;

class TwigExtensionSet extends Set implements ConfigurationInterface
{
    /**
     * @param Injector $injector
     */
    public function apply(Injector $injector)
    {
        $injector->prepare(\Twig_Environment::class, [$this, 'prepareExtension']);
    }

    /**
     * @param \Twig_Environment $environment
     * @param Injector          $injector
     */
    public function prepareExtension(\Twig_Environment $environment, Injector $injector)
    {
        $extensions = $this;

        if ($environment->isDebug()) {
            $extensions = $this->withValue(\Twig_Extension_Debug::class);
        }

        foreach ($extensions as $extension) {
            if (!is_object($extension)) {
                $environment->addExtension(
                    $injector->make($extension)
                );
            }
        }
    }
}
