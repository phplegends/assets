<?php


include_once __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Assets;

Assets::setConfig([

    'base_uri' => 'http://localhost:8000/assets',

    'base_path' => __DIR__ . '/assets',

    'compiled' => '_compiled_assets',

    'path_aliases' 	=> [
        'css.posts' => 'css/posts',
        'js.admin'  => 'js/admin',
        'admin'     => '{folder}/admin',
        'user'      => '{folder}/user'
    ],

    //'version' => '1.0'
]);

// Concatenado arquivos

echo  Assets::concatScript(['js.admin:default.js' , 'admin:app.js']);


echo  Assets::concatScript(['js/admin/default.js' , 'js/admin/app.js']);

// Concatenando css

echo  Assets::concatStyle(['admin:default.css' , 'user:index.css']);
