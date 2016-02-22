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

	public static function image($assets)
	{
		$collection = (new ImageCollection)->addArray((array) $assets);

		return static::configureCollection($collection);
	}

	public static function style($assets)
	{
		$collection = (new CssCollection)->addArray((array) $assets);

		return static::configureCollection($collection);
	}

	public static function add(array $assets)
	{
		return  static::createManager()
							->addCollection(new JavascriptCollection)
							->addCollection(new CssCollection)
							->addCollection(new ImageCollection)
							->addArray($assets);
	}

	public static function script($assets)
	{
		$collection = (new JavascriptCollection)->addArray((array) $assets);

		return static::configureCollection($collection);
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

		$type = $collection->getAssetAlias();

		if (isset(static::$config[$type]['namespaces'])) {

			foreach ((array) static::$config[$type]['namespaces'] as $namespace => $path) {

				$collection->addNamespace($namespace, $path, $type);
			}
		}

		return $manager;
	}

}