<?php
declare(strict_types=1);

namespace AlexMasterov\EquipTwig\Loader;

use AlexMasterov\EquipTwig\Exception\LoaderException;
use Twig_LoaderInterface;
use Twig_Source;

final class FilesystemLoader implements Twig_LoaderInterface
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

    public function __construct(string $path, array $fileExtensions = null)
    {
        $this->path = $path;

        if ($fileExtensions) {
            $this->fileExtensions = $fileExtensions;
        }
    }

    /**
     * @inheritDoc
     */
    public function getSourceContext($name)
    {
        $code = file_get_contents($this->template($name));

        return new Twig_Source($code, $name);
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
     *  When $name is not found.
     */
    private function template($name)
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $found = $this->findTemplate($name);
        if (null === $found) {
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

        foreach ($files as $file) {
            $filepath = $this->path . DIRECTORY_SEPARATOR . $file;
            if (is_file($filepath) && is_readable($filepath)) {
                return realpath($filepath);
            }
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return Generator
     */
    private function possibleTemplateFiles($name)
    {
        yield $name = $this->normalizeName($name);

        foreach ($this->fileExtensions as $extension) {
            yield "{$name}.{$extension}";
        }
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function normalizeName($name)
    {
        return preg_replace('#/{2,}#',
            DIRECTORY_SEPARATOR,
            str_replace('\\', DIRECTORY_SEPARATOR, $name)
        );
    }
}
