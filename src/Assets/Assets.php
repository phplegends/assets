<?php 

namespace PHPLegends\Assets;

use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Collections\CollectionInterface;

class Assets
{
	protected static $config = [];

	public static function create(array $config = [])
	{
		if (empty($config)) {

			$manager = new Manager;

			$manager->addCollection(new JavascriptCollection);

			$manager->addCollection(new CssCollection);

			return $manager;
			
		}

		return Manager::createFromConfig($config);
	}

	public static function setConfig(array $config)
	{
		static::$config = $config;
	}

	public static function css(array $cssFiles)
	{
		$collection = new CssCollection;

		static::configCollection('css', $collection);

		static::loadFiles($cssFiles, $collection);

		return $collection;
	}

	public static function js(array $jsFiles)
	{
		$collection = new JavascriptCollection;

		static::configCollection('js', $collection);

		static::loadFiles($jsFiles, $collection);

		return $collection;
	}

	protected static function loadFiles(array $files, CollectionInterface $collection)
	{
		foreach ($files as $css) {

			$collection->add($css);
		}

		return $collection;

	}

	protected static function configCollection($type, CollectionInterface $collection)
	{
		if (isset(static::$config[$type]['namespaces'])) {

			foreach (static::$config[$type]['namespaces'] as $namespace => $path) {

				$collection->addNamespace($namespace, $path);
			}
		}

		if (isset(static::$config['base'])) {

		    $collection->setBaseUri(static::$config['base']);
		}

		return $collection;
	}

}