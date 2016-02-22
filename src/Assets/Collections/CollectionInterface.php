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
    * Get all items
    */
    public function all();

    /**
    * Validates the file extension of asset
    * @param string $asset
    * @return array
    */
    public function getExtensions();
}