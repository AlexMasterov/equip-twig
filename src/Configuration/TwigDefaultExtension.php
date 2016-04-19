<?php

namespace Asmaster\EquipTwig\Configuration;

use Equip\SessionInterface;
use Asmaster\EquipTwig\Configuration\TwigExtensionSet;
use Asmaster\EquipTwig\Extension\SessionExtension;

class TwigDefaultExtension extends TwigExtensionSet
{
    /**
     * @param array $extensions
     */
    public function __construct(array $extensions = [])
    {
        // equip/session
        if (interface_exists(SessionInterface::class)) {
            $extensions[] = SessionExtension::class;
        }

        parent::__construct($extensions);
    }
}
