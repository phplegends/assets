<?php 

namespace PHPLegends\Assets;

use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;

class Assets
{
	protected $manager;

	public function __construct()
	{
		$this->manager = new Manager;

		$this->manager->addCollection(new JavascriptCollection);

		$this->manager->addCollection(new CssCollection);
	}

	public function getManager()
	{
		return $this->manager;
	}

	public function manager()
	{
		return $this->getManager();
	}

	public static function create()
	{
		return new self;
	}

	public static function factory(array $config)
	{
		$assets = new self;

		$manager = $assets->getManager();

		if (isset($config['base'])) {

			$manager->setBaseUri($config['base']);
		}

		if (isset($config['namespaces']) && is_array($config['namespaces']))
		{
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

}