<?php

namespace Asmaster\EquipTwig;

use Equip\Payload;

class TemplatePayload extends Payload
{
    /**
     * @var string
     */
    private $template;

    /**
     * @param string $template
     */
    public function withTemplate($template)
    {
        $copy = clone $this;
        $copy->template = $template;

        return $copy;
    }

    /**
     * @return string $template
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
