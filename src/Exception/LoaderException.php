<?php
declare(strict_types=1);

namespace AlexMasterov\EquipTwig\Exception;

use AlexMasterov\EquipTwig\Exception\ExceptionInterface;
use Twig_Error_Loader;

class LoaderException extends Twig_Error_Loader implements ExceptionInterface
{
    public static function notFound(string $name, string $where): self
    {
        return new static(sprintf(
            'Unable to find template `%s` (looked into: %s).',
            $name,
            $where
        ));
    }
}
