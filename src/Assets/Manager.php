<?php

namespace PHPLegends\Assets;

use PHPLegends\Assets\Collections\CollectionInterface;

class Manager
{
    protected $collections;

    protected $baseUri = null;

    public function addCollection(CollectionInterface $collection, $type = null)
    {

        if ($type === null) {

            $type = $collection->getExtension();
        }

        $this->collections[$type] = $collection;

        return $this;
    }

    public function addGlobalNamespace($name, $directory)
    {
        foreach (array_keys($this->collections) as $type) {

            $this->addNamespace($name, $directory, $type);
        }

        return $this;
    }

    public function addNamespace($namespace, $directory, $extensionName = null)
    {
        if ($extensionName === null) {

            foreach($this->collections as $type => $collection) {

                $suffixedDir = $directory . '/' . $type;

                $collection->addNamespace($namespace, $suffixedDir);
            }

            return $this;
        }

        $this->getCollection($extensionName)->addNamespace($namespace, $directory);

        return $this;
    }

    public function add($type, $file)
    {
        $this->getCollection($type)->add($file);

        return $this;
    }


    public function getCollection($type)
    {
        if (! isset($this->collections[$type])) {

            throw new \UnexpectedValueException(sprintf('Type %s collection is not added in manager', $type));
        }

        return $this->collections[$type];
    }

    public function getBaseUri()
    {
        return $this->baseUri;
    }

    public function setBaseUri($baseUri)
    {

        if (! filter_var($baseUri, FILTER_VALIDATE_URL)) {

            throw new \UnexpectedValueException('The value passed must be a url');
        }

        $this->baseUri = rtrim($baseUri, '/') . '/';

        return $this;
    }

    public function getUrls($type = null)
    {
        $urls = [];

        foreach ($this->collections as $collection) {

            foreach ($collection->getUrls() as $url) {

                $urls[] = $this->buildUrl($url);
            }
        }

        return $urls;
    }

    protected function buildUrl($url)
    {
        return $this->baseUri . $url;
    }

    public function getTags($type = null)
    {
        $urls = [];

        foreach ($this->collections as $collection) {

            foreach ($collection->getUrls() as $url) {

                $url = $this->buildUrl($url);

                $urls[] = $collection->buildTag($url);
            }
        }

        return $urls;
    }

    public function output($type = null)
    {
        return implode(PHP_EOL, $this->getTags($type));
    }

}

