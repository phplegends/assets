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

	}
}