<?php

namespace Asmaster\EquipTwig\Extension;

use Equip\SessionInterface;

trait SessionTrait
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
}
