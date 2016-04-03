<?php

namespace Asmaster\EquipTwig\Extension;

use Psr\Http\Message\ServerRequestInterface;

trait ServerRequestTrait
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }
}
