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

    /**
    * @var string
    */
    protected $basePath;

    /**
    * @var string|null
    */
    protected $version;


    /**
    * @param \PHPLegends\Assets\Collections\CollectionInterface[] $collections
    * @return void
    */
    public function __construct(array $collections = [])
    {
        foreach ($collections as $collection) {

            $this->addCollection($collection);

        }
    }

    /**
    * @param \PHPLegends\Assets\Collections\CollectionInterface $collection
    * @return PHPLegends\Assets\Manager
    */
    public function addCollection(CollectionInterface $collection)
    {
        $this->collections[$collection->getAssetAlias()] = $collection;

        return $this;
    }

    /**
    * @param string $name
    * @param string $directory
    * @return PHPLegends\Assets\Manager
    */
    public function addPathAlias($name, $directory)
    {
        $this->paths[$name] = '/' . trim($directory, '/');

        return $this;
    }
    
    /**
    * @param string $asset
    * @return PHPLegends\Assets\Manager
    */
    public function add($asset)
    {

        $collection = $this->findCollectionByFileExtension($asset);

        if ($collection === null) {

            $message =  sprintf(
                'The collection of extension "%s" is not registred',
                pathinfo($asset, PATHINFO_EXTENSION)
            );

            throw new \InvalidArgumentException($message);
        }

        $asset = $this->parsePathAlias($asset);

        $collection->add($asset);

        return $this;
    }

    /**
    * Add files according to order of elements
    * @param array $assets
    * @return PHPLegends\Assets\Manager
    */
    public function addArray(array $assets)
    {

        foreach ($assets as $asset) $this->add($asset);

        return $this;
    }

    /**
    * @param string $asset
    * @return PHPLegends\Assets\Manager
    **/
    protected function findCollectionByFileExtension($asset)
    {

        foreach ($this->collections as $collection) {

            if ($collection->validateExtension($asset)) {

                return $collection;
            }
        }

        return null;
    }

    /**
    * @return array
    */
    public function getTags()
    {
        return $this->collectionToMappedList(function ($item, $collection)
        {
            return $collection->buildTag($this->buildUrl($item));
        });
    }

    /**
    * @return array
    */
    public function getFilenames()
    {
        return $this->collectionToMappedList(function($item, $collection)
        {
            return $this->getBasePath() . $item;
        });
    }

    /**
    * @param string $uri
    * @return PHPLegends\Assets\Manager
    */
    public function setBaseUri($uri)
    {
        $this->baseUri = rtrim($uri, '/');

        return $this;
    }

    /**
    * @return string
    */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
    * @param string $path
    * @return \PHPLegends\Assets\Manager
    */
    public function setBasePath($path)
    {
        $realpath = realpath($path);

        if ($realpath === false) {

            throw new \InvalidArgumentException("The base path '{$path}' doesn't exists");
        }

        $this->basePath = rtrim($realpath, '/');

        return $this;
    }

    /**
    * @return string
    */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
    * @return string
    */
    public function output()
    {
        return implode(PHP_EOL, $this->getTags());
    }

    /**
    * yes! this returns a string
    * @return string
    */
    public function __toString()
    {
        return $this->output();
    }

    /**
    * @param \PHPLegends\Assets\Collection\CollectionInterface
    * @param callable $callback
    * @return array
    */
    protected function mapCollection(CollectionInterface $collection, callable $callback)
    {
        $items = [];

        foreach ($collection->all() as $item)  {

            $items[] = $callback($item, $collection);
        }

        return $items;
    }

    /**
    * @param callable $callback
    * @return array
    */
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

    /**
    * @param string $path
    * @return array
    */
    protected function extractPathAlias($path)
    {
        $separator = ':';

        if (strpos($path, $separator) === false) {

            return [null, $path];
        }

        return explode($separator, $path);
    }

    /**
    * @param string $path
    * @return string
    */
    protected function parsePathAlias($path)
    {
        list($alias, $asset) = $this->extractPathAlias($path);

        $asset = '/'. ltrim($asset, '/');

        if ($alias === null) return $asset;

        if (! isset($this->paths[$alias])) {

            throw new \UnexpectedValueException(
                "Alias with name '{$alias}' doesn't registred"
            );
        }

        $path = $this->paths[$alias];

        $path = $this->parsePathWildcards($path, $asset);

        return $path . $asset;
    }

    /**
    * @param string $path
    * @param string $asset
    * @return string
    */
    protected function parsePathWildcards($path, $asset)
    {

        $collection = $this->findCollectionByFileExtension($asset);

        return strtr($path, ['{folder}' => $collection->getAssetAlias()]);
    }

    /**
    * @param string $version
    * @return \PHPLegends\Assets\Manager
    */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
    * @return string
    */
    public function getVersion()
    {
        return $this->version;
    }

    /**
    * @return string
    */
    protected function buildUrl($asset)
    {
        $version = $this->getVersion();

        if ($version !== null) {

            $asset .= '?' . http_build_query(['_version' => $this->getVersion()]);
        }

        return $this->getBaseUri() . $asset;
    }

}

