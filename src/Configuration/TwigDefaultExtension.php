<?php

namespace Asmaster\EquipTwig\Configuration;

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
        if (interface_exists('Equip\SessionInterface')) {
            $extensions[] = SessionExtension::class;
        }

        parent::__construct($extensions);
    }
}
