<?php

namespace Asmaster\EquipTwig\Extension;

use Equip\SessionInterface;
use Twig_Extension as TwigExtension;
use Twig_Extension_GlobalsInterface as TwigExtensionGlobalsInterface;

class SessionExtension extends TwigExtension implements TwigExtensionGlobalsInterface
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
