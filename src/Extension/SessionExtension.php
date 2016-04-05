<?php

namespace Asmaster\EquipTwig\Extension;

class SessionExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    use SessionTrait;

    /**
     * @return string The extension name
     */
    public function getName()
    {
        return 'session';
    }

    public function getGlobals()
    {
        return [
            'session' => $this->session
        ];
    }
}
