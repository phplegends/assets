<?php 

namespace PHPLegends\Assets;

use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\ImageCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Collections\CollectionInterface;

class Assets
{
	protected static $config = [];

	public static function setConfig(array $config)
	{
		static::$config = $config;
	}

	public static function image($assets, array $attributes = [])
	{
		$collection = (new ImageCollection)->setAttributes($attributes);

		return static::configureCollection($collection)->addArray((array) $assets);
	}

	public static function style($assets, array $attributes = [])
	{
		$collection = (new CssCollection)->setAttributes($attributes);

		return static::configureCollection($collection)->addArray((array) $assets);
	}

	public static function add(array $assets)
	{
		return  static::createManager()
							->addCollection(new JavascriptCollection)
							->addCollection(new CssCollection)
							->addCollection(new ImageCollection)
							->addArray($assets);
	}

	public static function script($assets, array $attributes = [])
	{
		$collection = (new JavascriptCollection)->setAttributes($attributes);

		return static::configureCollection($collection)
					  ->addArray((array) $assets);
	}

	protected static function createManager()
	{
		$manager = new Manager;

		// Defines the nampesace globally

		if (isset(static::$config['base_uri'])) {

			$manager->setBaseUri(static::$config['base_uri']);
		}

		if (isset(static::$config['path_alias']) ) {

			foreach ((array) static::$config['path_alias'] as $alias => $path) {

				$manager->addPathAlias($alias, $path);
			}	
		}

		return $manager;
	}

	protected static function configureCollection(CollectionInterface $collection)
	{
		$manager = static::createManager();

		$manager->addCollection($collection);

		return $manager;
	}

}