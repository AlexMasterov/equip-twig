<?php

namespace Asmaster\EquipTwig\Loader;

use Asmaster\EquipTwig\Exception\LoaderException;
use Twig_ExistsLoaderInterface as TwigExistsLoader;
use Twig_LoaderInterface as TwigLoader;

final class FilesystemLoader implements TwigLoader, TwigExistsLoader
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $fileExtensions = ['html.twig', 'twig'];

    /**
     * @var array
     */
    private $cache = [];

    /**
     * @param string $path           The template directory path
     * @param array  $fileExtensions The template file extensions
     */
    public function __construct($path, array $fileExtensions = null)
    {
        $this->path = $path;

        if ($fileExtensions) {
            $this->fileExtensions = $fileExtensions;
        }
    }

    /**
     * @inheritDoc
     */
    public function getSource($name)
    {
        return file_get_contents($this->template($name));
    }

    /**
     * @inheritDoc
     */
    public function getCacheKey($name)
    {
        return $this->template($name);
    }

    /**
     * @inheritDoc
     */
    public function isFresh($name, $time)
    {
        return filemtime($this->template($name)) <= $time;
    }

    /**
     * @inheritDoc
     */
    public function exists($name)
    {
        if (isset($this->cache[$name])) {
            return true;
        }

        return (bool) $this->findTemplate($name);
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws LoaderException
     * When $name is not found
     */
    private function template($name)
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $found = $this->findTemplate($name);
        if (!$found) {
            throw LoaderException::notFound($name, $this->path);
        }

        return $this->cache[$name] = $found;
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    private function findTemplate($name)
    {
        $files = $this->possibleTemplateFiles($name);

        foreach($files as $file) {
            $filepath = $this->path . DIRECTORY_SEPARATOR . $file;
            if (is_readable($filepath)) {
                return realpath($filepath);
            }
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return array
     */
    private function possibleTemplateFiles($name)
    {
        $name = $this->normalizeName($name);

        $templates = [$name];
        foreach($this->fileExtensions as $extension) {
            $templates[] = "$name.$extension";
        }

        return $templates;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function normalizeName($name)
    {
        return preg_replace('#/{2,}#', DIRECTORY_SEPARATOR,
            str_replace('\\', DIRECTORY_SEPARATOR, $name)
        );
    }
}
