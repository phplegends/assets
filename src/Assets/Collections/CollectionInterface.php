<?php

namespace PHPLegends\Assets\Collections;

interface CollectionInterface
{

	/**
	* Add asset file to collection
	* @param string $asset
	* @return 
	*/
    public function add($asset);

    /**
    * Add alias for a directory in collection
    * @param string $namespace
    * @param string $directory
    */
    public function addNamespace($namespace, $directory);

    /**
    * Retrieves the content tag with url of asset
    * @param string $url
    * @param array $attributes
    */
    public function buildTag($url, array $attributes = []);

    /**
    * Retrieves the alias of collection 
    */
    public function getAssetAlias();

    /**
    * Get all tags of collection
    * @return array
    */
    public function getTags();

    /**
    * Get all urls of asset collection
    */
    public function getUrls();

    /**
    * Determines the base uri for assets
    * @param string $baseUri
    */
    public function setBaseUri($baseUri);

    /**
    * @return string
    */
    public function getBaseUri();

    /**
    * Validates the file extension of asset
    * @param string $asset
    * @return array
    */
    public function getExtensions();
}