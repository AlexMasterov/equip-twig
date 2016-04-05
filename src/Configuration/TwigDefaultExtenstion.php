<?php

namespace Asmaster\EquipTwig\Configuration;

use Asmaster\EquipTwig\Extension\RequestExtension;
use Asmaster\EquipTwig\Extension\Session;

class TwigDefaultExtension extends TwigExtensionSet
{
    /**
     * @param array $extensions
     */
    public function __construct(array $extensions = [])
    {
        $defaults = [
            RequestExtension::class
        ];

        // equip/session
        if (interface_exists('Equip\SessionInterface')) {
            $defaults[] = Session::class;
        }

        parent::__construct(array_merge($defaults, $extensions));
    }
}
