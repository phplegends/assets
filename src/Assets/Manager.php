<?php

namespace PHPLegends\Assets;

use PHPLegends\Assets\Collections\CollectionInterface;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Collections\JavascriptCollection;

class Manager
{
    protected $collections;

    protected $baseUri = null; 

    public function addCollection(CollectionInterface $collection)
    {

        $assetType = $collection->getAssetAlias();

        $this->collections[$assetType] = $collection;

        return $this;
    }

    public function addNamespace($namespace, $directory, $assetType = null)
    {
        if ($assetType === null) {

            foreach ($this->collections as $type => $collection) {

                $suffixedDir = strtr($directory, ['{path}' => $type]);

                $collection->addNamespace($namespace, $suffixedDir);
            }

            return $this;
        }

        $this->getCollection($assetType)->addNamespace($namespace, $directory);

        return $this;
    }


    protected function getCollectionByFileExtension($asset)
    {

        foreach ($this->collections as $collection) {

            if ($collection->validateExtension($asset)) {

                return $this->getCollection($collection->getAssetAlias());
            }
        }

        return null;
    }

    public function add($asset)
    {

        $collection = $this->getCollectionByFileExtension($asset);

        if ($collection === null) {

            throw new \InvalidArgumentException(
                sprintf(
                    'The collection of extension "%s" is not registred',
                    pathinfo($asset, PATHINFO_EXTENSION)
                )
            );
        }

        $collection->add($asset);

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

    public function getUrls()
    {
        $urls = [];

        foreach ($this->collections as $collection) {

            if ($this->baseUri) $collection->setBaseUri($this->baseUri);

            foreach ($collection->getUrls() as $url) {

                $urls[] = $url;
            }
        }

        return $urls;
    }


    public function getTags()
    {
        $tags = [];

        foreach ($this->collections as $collection) {

           if ($this->baseUri) $collection->setBaseUri($this->baseUri);

            foreach ($collection->getTags() as $tag) {

                $tags[] = $tag;
            }
        }

        return $tags;
    }

    public function output()
    {
        return implode(PHP_EOL, $this->getTags());
    }


    public static function createFromConfig(array $config)
    {
        $manager = new self;

        $manager->addCollection(new CssCollection);

        $manager->addCollection(new JavascriptCollection);

        if (isset($config['base'])) {

            $manager->setBaseUri($config['base']);
        }

        if (isset($config['namespaces']) && is_array($config['namespaces'])) {

            foreach($config['namespaces'] as $namespace => $directory) {

                $manager->addGlobalNamespace($namespace, $directory);
            }
        }

        foreach (['css', 'js'] as $assetType) {
            
            if (isset($config[$assetType]['namespaces'])) {

                foreach((array) $config[$assetType]['namespaces'] as $namespace => $directory) {

                    $manager->addNamespace($namespace, $directory, $assetType);
                }
            }

            if (isset($config[$assetType]['add'])) {

                foreach((array) $config[$assetType]['add'] as $file) {

                    $manager->add($assetType, $file);
                }
            }

        }

        return $manager;

    }

    public function __toString()
    {
        return $this->output();
    }

}

