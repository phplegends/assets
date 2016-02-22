<?php


include_once __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Assets;

Assets::setConfig([

    'path_alias' 	=> [
        'js'        => 'assets/js',
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
    'admin:default.css',
    'asset/js/teste.js'
]);
 

echo Assets::script('admin:diferente.js', ['assync', 'defer']);

echo Assets::image('admin:image.png', ['height' => '"', 'width' => 80]);

