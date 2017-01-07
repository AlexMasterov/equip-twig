<?php

namespace AlexMasterov\EquipTwig\Exception;

use InvalidArgumentException;
use Twig_ExtensionInterface;

class ExtensionException extends InvalidArgumentException
{
    /**
     * @param mixed $spec
     *
     * @return static
     */
    public static function invalidExtension($spec)
    {
        if (is_object($spec)) {
            $spec = get_class($spec);
        }

        return new static(sprintf(
            'Twig extension `%s` must implement `%s`',
            $spec,
            Twig_ExtensionInterface::class
        ));
    }
}
