<?php

namespace AlexMasterov\EquipTwig\Extension;

use Equip\SessionInterface;
use Twig_Extension;

class SessionExtension extends Twig_Extension
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

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
