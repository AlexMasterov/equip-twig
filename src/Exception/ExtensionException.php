<?php

namespace AlexMasterov\EquipTwig\Exception;

use AlexMasterov\EquipTwig\Exception\ExceptionInterface;
use InvalidArgumentException;
use Twig_ExtensionInterface;

class ExtensionException extends InvalidArgumentException implements ExceptionInterface
{
    /**
     * @param string|object $spec
     *
     * @return static
     */
    public static function invalidClass($spec)
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
