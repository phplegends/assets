<?php


include_once __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Assets;


// $manager = Assets::create()
//                  ->getManager()
//                  ->addNamespace('home', 'assets')
//                  ->setBaseUri('http://assets.cardvantagens.com')
//                  ->add('js', 'home:*')
//                  ->add('js', 'home:admin/*')
//                  ->add('css', 'admin/teste');

// //print_r($manager);

// echo $manager->output();

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
        ],

        'add' => [
            'admin:default.js'
        ]   
    ]
];


$assets = Assets::factory($config);

$assets->add('js', 'admin:site');

$assets->add('js', 'admin:site');


$assets->add('css', 'u.editors:index');

$assets->add('css', 'u.posters:post');

echo $assets->output();