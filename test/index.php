<?php


include_once __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Assets;

$config = [

    'base' => 'http://localhost:8000/assets',

    'css' => [

        'namespaces' => [
            'u.editors' => 'css/user/editors',
            'u.posters' => 'css/user/posters'
        ]
    ],

    'js' => [
        'namespaces' => [
            'admin' => 'js/admin'
        ] 
    ]
];


Assets::setConfig($config);

echo Assets::css(['u.editors:default.css']);

echo Assets::css(['u.posters:post.css']);

echo Assets::js(['admin:default.js']);