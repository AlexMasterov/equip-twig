<?php

namespace AlexMasterov\EquipTwig\Extension;

use Equip\SessionInterface;
use Twig_Extension;
use Twig_Extension_GlobalsInterface;

final class SessionExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
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
