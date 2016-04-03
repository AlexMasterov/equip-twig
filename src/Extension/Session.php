<?php

namespace Asmaster\EquipTwig\Extension;

class Session extends \Twig_Extension
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
