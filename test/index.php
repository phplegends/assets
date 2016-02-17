<?php


include_once __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Assets;


$manager = Assets::create()
                 ->getManager()
                 ->addNamespace('home', 'assets')
                 ->setBaseUri('http://assets.cardvantagens.com')
                 ->add('js', 'home:*')
                 ->add('js', 'home:admin/*')
                 ->add('css', 'admin/teste');

//print_r($manager);

echo $manager->output();
