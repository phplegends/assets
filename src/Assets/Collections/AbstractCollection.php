<?php

namespace PHPLegends\Assets\Collections;

abstract class AbstractCollection implements CollectionInterface, TagInterface
{

    const NAMESPACE_SEPARATOR = ':';

    protected $items = [];

    protected $namespaces = [];

    private $baseUrl;

    abstract public function getExtension();

    abstract public function buildTag($url);

    public function addNamespace($namespace, $dirname)
    {
        $this->namespaces[$namespace] = rtrim($dirname, '/') . '/';
    }

    protected function normalizeAssetName($file)
    {
        $regex = sprintf('/(\.%s)$/i', $this->getExtension());

        if (preg_match($regex, $file) == 0) {

            $file .= '.' . $this->getExtension();
        }

        return $file;
    }

    public function add($file)
    {

        $file = $this->normalizeAssetName($file);

        if (strpos($file, '*') !== false) {

            $glob = $this->parseNamespace($file);

            foreach (glob($glob) as $uri) {

                $this->add($uri);
            }

            return $this;
        }

        $this->items[$file] = $file;
    }

    public function getItems()
    {
        return array_values($this->items);
    }

    protected function parseNamespace($namespace)
    {
        if (strpos($namespace, static::NAMESPACE_SEPARATOR) === false) {

            return $namespace;
        }

        list($name, $file) = explode(static::NAMESPACE_SEPARATOR, $namespace);

        if (! isset($this->namespaces[$name])) {

            throw new \RuntimeException(sprintf('Namespace "%s" not found', $name));
        }

        return $this->namespaces[$name] . $file;
    }

    public function getUrls()
    {
        $urls = [];

        foreach ($this->items as $item) {

            $uri = $this->parseNamespace($item);

            $urls[] = $uri;
        }

        return $urls;
    }

    public function getTags()
    {
        return array_map(function ($url)
        {
            return $this->buildTag($url);

        }, $this->getUrls());
    }
}