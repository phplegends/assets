<?php


include_once __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Concatenator;
use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Collections\ImageCollection;

$manager = new Manager([
	new JavascriptCollection,
	new CssCollection,
	new ImageCollection,
]);


$manager->addPathAlias('js.adm', '/assets/js/admin');

$manager->addPathAlias('css.adm', '/assets/css/user');

$manager->addPathAlias('img.adm', '/assets/img/user');

$manager->add('js.adm:default.js')
		->add('css.adm:default.css')
		->add('js.adm:default.jpg')
		->add('img.adm:default.jpeg')
		->add('img.adm:default.png');

echo $manager->output();

$concat = new Concatenator([
	'./assets/css/admin/default.css',
	'./assets/css/user/index.css',
]);

$concat->save('./assets/css');