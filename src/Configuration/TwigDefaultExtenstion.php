<?php

namespace Asmaster\EquipTwig\Configuration;

use Asmaster\EquipTwig\Extension\RequestUri;
use Asmaster\EquipTwig\Extension\Session;

class TwigDefaultExtenstion extends TwigExtensionSet
{
    /**
     * @param array $extensions
     */
    public function __construct(array $extensions = [])
    {
        $defaults = [
            RequestUri::class
        ];

        // equip/session
        if (interface_exists('Equip\SessionInterface')) {
            $defaults[] = Session::class;
        }

        parent::__construct(array_merge($defaults, $extensions));
    }
}
