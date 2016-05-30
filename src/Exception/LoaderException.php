<?php

namespace Asmaster\EquipTwig\Exception;

use Asmaster\EquipTwig\Exception\ExceptionInterface;
use Twig_Error_Loader as TwigErrorLoader;

class LoaderException extends TwigErrorLoader implements ExceptionInterface
{
    /**
     * @param string $name  The template name
     * @param string $where The template directory path
     *
     * @return static
     */
    public static function notFound($name, $where)
    {
        return new static(sprintf(
            'Unable to find template `%s` (looked into: %s).',
            $name,
            $where
        ));
    }
}
