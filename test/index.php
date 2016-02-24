<?php


include_once __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Assets;
use PHPLegends\Legendary\View;

View::config([

    'compiled' => __DIR__ . '/temp',

    'path'     => __DIR__ . '/views',
]);

Assets::config([

    /*
        Por que isso? O cara pode ter acesso a um path, e esse path, porém,
        ter acesso via subdomínio
    */

    //'base_uri' => 'http://localhost:8000/assets',

    'base_uri' => '/assets',

    /*
        A pasta base de todos o assets. Aqui é onde podemos processar o caminho completo do arquivo.
    */
    'path' => __DIR__ . '/assets',

    // Diretório onde são compilados os arquivos unidos pelo Concatenator
    'compiled' => '_compiled_assets',

    // Adiciona "alias" para um path específico

    'path_aliases' 	=> [
        // O caractere curinga folder exclui a necessidade de criar um 
        // Namespace para cada tipo de asset
        // Isso será traduzido para 'css/chat', 'js/chat' e 'img/chat'
        'chat' => '{folder}/chat'
    ],

    // Adiciona a famosa query string para burlar o cache do navegador
    
    'version' => '1.0'
]);


class_alias('PHPLegends\Assets\Assets', 'Assets');

echo View::create('home', [

    'nome' => filter_input(INPUT_GET, 'nome')
]);
