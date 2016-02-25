<?php

namespace PHPLegends\Assets\Collections;

interface CollectionInterface
{

	/**
	* Add asset file to collection
	* @param string $asset
	* @return \PHPLegends\Assets\Collections\CollectionInterface
	*/
    public function add($asset);


    /**
    * Retrieves the content tag with url of asset
    * @param string $url
    * @param array $attributes
    * @return string
    */
    public function buildTag($asset);

    /**
    * Retrieves the alias of collection 
    * @return string
    */
    public function getAssetAlias();

    /**
    * Map all items
    * @return array
    */
    public function map(callable $callback = null);

    /**
    * Get all extension accept by collection
    * @param string $asset
    * @return array
    */
    public function getExtensions();

    /**
    * Validates the file extension of asset
    * @param string $asset
    * @return boolean
    */
    public function validateExtension($asset);

}