<?php


include_once __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Assets;

Assets::setConfig([
    //'base_uri' 		=> 'https://assets.my-site.com.br/',
    'path_alias' 	=> [
		'css.posts' => 'assets/css/posts',
		'js.admin'  => 'assets/js/admin',
		'admin'     => 'asset/{folder}/admin'
    ], 
]);

echo Assets::add([
    'css.posts:default.css',
    'css.posts:post.css',
    'js.admin:default.js',
    'admin:teste.js',
    'admin:default.css'
]);
