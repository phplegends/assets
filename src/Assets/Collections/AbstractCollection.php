<?php

namespace PHPLegends\Assets\Collections;

abstract class AbstractCollection implements CollectionInterface
{

    const NAMESPACE_SEPARATOR = ':';

    /**
    * @var array
    */
    protected $items = [];

    /**
    * @var array
    */
    protected $namespaces = [];

    /**
    * @var string|null
    */
    protected $baseUri;

    /**
    * @{inheritdoc}
    */
    abstract public function getAssetAlias();

    /**
    * @{inheritdoc}
    */
    abstract public function buildTag($url, array $attributes = []);

    public function validateExtension($asset)
    {
        $regex = sprintf('/\.(%s)$/i', implode('|', $this->getExtensions()));

        return (boolean) preg_match($regex, $asset);
    }

    public function setBaseUri($baseUri)
    {
        $this->baseUri = rtrim($baseUri, '/') . '/';

        return $this;
    }

    public function getBaseUri()
    {
        return $this->baseUri;
    }

    public function addNamespace($namespace, $dirname)
    {
        $this->namespaces[$namespace] = rtrim($dirname, '/') . '/';
    }

    public function add($asset)
    {
        if (! $this->validateExtension($asset)) {

            throw new \UnexpectedValueException(
                sprintf('Invalid extension for "%s"', $this->getAssetAlias())
            );
        }

        if (strpos($asset, '*') !== false) {

            $glob = $this->parseNamespace($file);

            foreach (glob($glob) as $uri) {

                $this->add($uri);
            }

            return $this;
        }

        $asset = $this->parseNamespace($asset);

        $this->items[$asset] = $asset;

        return $this;
    }

    public function addArray(array $assets)
    {
        foreach ($assets as $asset) $this->add($asset);

        return $this;
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
        return array_map(function ($url)
        {
            return $this->getBaseUri() . $url;

        }, $this->items);
    }

    public function getTags()
    {
        return array_map(function ($url)
        {
            return $this->buildTag($url);

        }, $this->getUrls());
    }


    public function output()
    {
        return implode(PHP_EOL, $this->getTags());
    }

    public function __toString()
    {
        return $this->output();
    }
}