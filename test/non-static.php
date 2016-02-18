<?php


include_once __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Collections\ImageCollection;

$manager = new Manager;

$manager->addCollection(new JavascriptCollection);

$manager->addCollection(new CssCollection);

$manager->addCollection(new ImageCollection);

// global 

$manager->addNamespace('admin', 'assets/{path}/admin');

$manager->addNamespace('user', 'assets/css/user', 'css');

$manager->setBaseUri('http://localhost:8000');

$manager->add('admin:default.js')
		->add('admin:default.css')
		->add('user:default.css')
		->add('admin:default.jpg')
		->add('admin:default.jpeg')
		->add('admin:default.png');

echo $manager->output();