<?php

namespace Asmaster\EquipTwig\Extension;

class RequestUri extends \Twig_Extension
{
    use ServerRequestTrait;

    /**
     * @return string The extension name
     */
    public function getName()
    {
        return 'requestUri';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('absolute_url', [$this, 'generateAbsoluteUrl'])
        ];
    }

    /**
     * @param string $path
     * @return string
     */
    public function generateAbsoluteUrl($path)
    {
        if ($this->isNetworkPath($path)) {
            return $path;
        }

        $uri = $this->request->getUri();

        if ('' === $host = $uri->getHost()) {
            return $path;
        }

        if ($uri->getPort()) {
            $host .= ':'.$uri->getPort();
        }

        if (! $this->hasLeadingSlash($path)) {
            $path = rtrim($uri->getPath(), '/').'/'.$path;
        }

        return $uri->getScheme().'://'.$host.$path;
    }

    /**
     * @param string $path
     * @return bool
     */
    private function isNetworkPath($path)
    {
        return false !== strpos($path, '://') || '//' === substr($path, 0, 2);
    }

    /**
     * @param string $path
     * @return bool
     */
    private function hasLeadingSlash($path)
    {
        return isset($path[0]) && '/' === $path[0];
    }
}
