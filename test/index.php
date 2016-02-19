<?php


include_once __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Assets;

$config = [

    'base' => 'http://localhost:8000/assets',

    'namespaces' => [
        'admin'        => '{asset}/admin/',
        'user.editors' => '{asset}/user/editors',
        'user.posters' => '{asset}/user/posters',
    ],

    // 'css' => [

    //     'namespaces' => [
    //         'u.editors' => 'css/user/editors',
    //         'u.posters' => 'css/user/posters'
    //     ]
    // ],

    // 'js' => [
    //     'namespaces' => [
    //         'admin' => 'js/admin'
    //     ] 
    // ]
];


Assets::setConfig($config);


var_dump(Assets::add(['x.js']));

echo Assets::style('user.editors:default.css');

echo Assets::style('user.posters:post.css');

echo Assets::script(['admin:default.js']);

echo Assets::script(['admin:default.js']);