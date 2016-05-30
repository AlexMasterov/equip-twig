<?php

namespace Asmaster\EquipTwig\Exception;

use Asmaster\EquipTwig\Exception\ExceptionInterface;
use InvalidArgumentException;
use Twig_ExtensionInterface as TwigExtensionInterface;

class ExtensionException extends InvalidArgumentException implements ExceptionInterface
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
            TwigExtensionInterface::class
        ));
    }
}
