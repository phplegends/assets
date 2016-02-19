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
							->addCollection(new ImageCollection);
	}

	public static function script($assets)
	{
		$collection = (new JavascriptCollection)->addArray((array) $assets);

		return static::configureCollection($collection);
	}

	protected static function createManager()
	{
		$manager = new Manager;

		if (isset(static::$config['base'])) {

		    $manager->setBaseUri(static::$config['base']);
		}

		// Defines the nampesace globally

		if (isset(static::$config['namespaces']) ) {

			foreach ((array) static::$config['namespaces'] as $namespace => $path) {

				$manager->addNamespace($namespace, $path);
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