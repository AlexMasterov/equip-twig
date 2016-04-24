<?php

namespace Asmaster\EquipTwig\Exception;

use InvalidArgumentException;

class ExtensionException extends InvalidArgumentException
{
    /**
     * @param mixed $extension
     *
     * @return static
     */
    public static function invalidExtension($extension)
    {
        if (is_object($extension)) {
            $extension = get_class($extension);
        }

        return new static(sprintf(
            'Twig extension `%s` must implement Twig_ExtensionInterface',
            $extension
        ));
    }
}
