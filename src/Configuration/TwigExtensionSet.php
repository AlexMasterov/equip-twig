<?php

namespace Asmaster\EquipTwig\Configuration;

use Auryn\Injector;
use Equip\Structure\Set;
use Equip\Configuration\ConfigurationInterface;
use Twig_Environment as TwigEnvironment;
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
     */
    public function prepareExtension(TwigEnvironment $environment, Injector $injector)
    {
        $extensions = $this->toArray();

        if ($environment->isDebug()) {
            $extensions[] = TwigExtensionDebug::class;
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
