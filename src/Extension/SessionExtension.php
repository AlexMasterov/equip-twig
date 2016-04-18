<?php

namespace Asmaster\EquipTwig\Extension;

use Twig_Extension;
use Twig_Extension_GlobalsInterface;

class SessionExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
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
