<?php

namespace Asmaster\EquipTwig\Configuration;

use Asmaster\EquipTwig\Configuration\TwigExtensionSet;
use Asmaster\EquipTwig\Extension\SessionExtension;
use Equip\SessionInterface;

class TwigDefaultExtension extends TwigExtensionSet
{
    /**
     * @param array $extensions
     */
    public function __construct(array $extensions = [])
    {
        $defaults = [];

        // equip/session
        if (interface_exists(SessionInterface::class)) {
            $defaults[] = SessionExtension::class;
        }

        parent::__construct(array_merge($defaults, $extensions));
    }
}
