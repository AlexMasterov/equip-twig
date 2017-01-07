<?php
declare(strict_types=1);

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

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getName(): string
    {
        return 'equip_session';
    }

    public function getGlobals(): array
    {
        return [
            'session' => $this->session
        ];
    }
}
