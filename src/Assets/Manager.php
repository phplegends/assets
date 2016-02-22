<?php

namespace PHPLegends\Assets;

use PHPLegends\Assets\Collections\CollectionInterface;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Collections\JavascriptCollection;

class Manager
{
    /**
    * @var array
    */
    protected $collections = [];

    /**
    * @var
    */
    protected $paths = [];

    /**
    * @var string
    */

    protected $baseUri;

    public function __construct(array $collections = [])
    {
        foreach ($collections as $collection) $this->addCollection($collection);
    }

    public function addCollection(CollectionInterface $collection)
    {
        $this->collections[$collection->getAssetAlias()] = $collection;

        return $this;
    }

    public function addPathAlias($name, $directory)
    {
        $this->paths[$name] = '/' . trim($directory, '/') . '/';

        return $this;
    }

    public function add($asset)
    {

        $collection = $this->getCollectionByFileExtension($asset);

        if ($collection === null) {

            $message =  sprintf(
                'The collection of extension "%s" is not registred',
                pathinfo($asset, PATHINFO_EXTENSION)
            );

            throw new \InvalidArgumentException($message);
        }

        $asset = $this->buildUrl($asset);

        $collection->add($asset);

        return $this;
    }

    public function addArray(array $assets)
    {

        foreach ($assets as $asset) $this->add($asset);

        return $this;
    }

    protected function getCollectionByFileExtension($asset)
    {

        foreach ($this->collections as $collection) {

            if ($collection->validateExtension($asset)) {

                return $collection;
            }
        }

        return null;
    }

    public function getTags()
    {
        return $this->collectionToMappedList(function ($item, $collection)
        {
            return $collection->buildTag($item);
        });
    }

    protected function mapCollection(CollectionInterface $collection, callable $callback)
    {
        $items = [];

        foreach ($collection->all() as $item)  {

            $items[] = $callback($item, $collection);
        }

        return $items;
    }

    protected function collectionToList()
    {
        $merge = [];

        foreach ($this->collections as $colletion) {

            $merge = array_merge($merge, $collection->all());
        }

        return $merge;
    }

    protected function collectionToMappedList(callable $callback)
    {
        $items = [];

        foreach ($this->collections as $collection) {

            $items = array_merge(
                $items, $this->mapCollection($collection, $callback)
            );
        }

        return $items;
    }

    public function setBaseUri($uri)
    {
        $this->baseUri = rtrim($uri, '/');

        return $this;
    }

    public function getBaseUri()
    {
        return $this->baseUri;
    }

    protected function extractPathAlias($path)
    {
        $separator = ':';

        if (strpos($path, $separator) === false) {

            return [null, $path];
        }

        return explode($separator, $path);
    }

    protected function parsePathAlias($path)
    {
        list($alias, $asset) = $this->extractPathAlias($path);

        if ($alias === null) return $asset;

        if (! isset($this->paths[$alias])) {

            throw new \UnexpectedValueException(
                "Alias '{$alias}' doesnt registred"
            );
        }

        $path = $this->paths[$alias];

        $path = $this->parsePathWildcards($path, $asset);

        return $path . $asset;
    }

    protected function parsePathWildcards($path, $asset)
    {
        $collection = $this->getCollectionByFileExtension($asset);

        return strtr($path, ['{folder}' => $collection->getAssetAlias()]);
    }

    protected function buildUrl($asset)
    {
        return $this->getBaseUri() . $this->parsePathAlias($asset);
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

