<?php

namespace Asmaster\EquipTwig\Extension;

class RequestExtension extends \Twig_Extension
{
    use ServerRequestTrait;

    /**
     * @return string The extension name
     */
    public function getName()
    {
        return 'request';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('absolute_url', [$this, 'generateAbsoluteUrl']),
            new \Twig_SimpleFunction('relative_url', [$this, 'generateRelativeUrl'])
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

        $host = $uri->getHost();
        if ('' === $host) {
            return $path;
        }

        if (null !== $uri->getPort()) {
            $host .= ':' . $uri->getPort();
        }

        if (! $this->hasLeadingSlash($path)) {
            $path = rtrim($uri->getPath(), '/') . '/' . $path;
        }

        return $uri->getScheme() . '://' . $host . $path;
    }

    /**
     * @param string $path
     * @return string
     */
    public function generateRelativeUrl($path)
    {
        if ($this->isNetworkPath($path) || ! $this->hasLeadingSlash($path)) {
            return $path;
        }

        $uri = $this->request->getUri();

        $basePath = $uri->getPath();
        if ($basePath === $path) {
            return '';
        }

        $baseParts = explode('/', $basePath, -1);
        $pathParts = explode('/', $path);

        foreach ($baseParts as $i => $segment) {
            if (isset($pathParts[$i]) && $segment === $pathParts[$i]) {
                unset($baseParts[$i], $pathParts[$i]);
            } else {
                break;
            }
        }

        $path = str_repeat('../', count($baseParts)) . implode('/', $pathParts);

        if ('' === $path) {
            return './';
        }

        if (empty($baseParts) && false !== strpos(current($pathParts), ':')) {
            $path = './' . $path;
        }

        return $path;
    }

    /**
     * @param string $path
     * @return bool
     */
    private function isNetworkPath($path)
    {
        return false !== strpos($path, '://')
            || '//' === substr($path, 0, 2);
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
