<?php

namespace Asmaster\EquipTwig\Extension;

use Twig_Extension as TwigExtension;
use Twig_Extension_GlobalsInterface as TwigExtensionGlobalsInterface;

class SessionExtension extends TwigExtension implements TwigExtensionGlobalsInterface
{
    use SessionTrait;

    /**
     * @return string The extension name
     */
    public function getName()
    {
        return 'equip_session';
    }

    public function getGlobals()
    {
        return [
            'session' => $this->session
        ];
    }
}
