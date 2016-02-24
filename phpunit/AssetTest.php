<?php

include __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Assets;

class AssetTest extends PHPUnit_Framework_TestCase
{ 
    public function testPathAndUri()
    {

        Assets::config([
            'path'     => __DIR__ . '/../test/assets',
        ]);

        $manager = Assets::style('css/reset.css');

        $this->assertEquals($manager->getBasePath(), '/var/www/assets/test/assets');
    }

    public function testAliasPath()
    {
        Assets::config([

            'base_uri' => '/assets',
            'path_aliases' => [
                'css.home' => 'css/home'
            ]
        ]);

        $this->assertEquals(
            (string) Assets::style('css.home:index.css'),
            '<link href="/assets/css/home/index.css" rel="stylesheet" type="text/css"/>'
        );
    }


    public function testVersionViaConfig()
    {
        Assets::config(['version' => '2.0']);

        $version = Assets::manager()->getVersion();

        $this->assertEquals($version, '2.0');

    }


    public function testPathAlias()
    {

        Assets::config([
            'path_aliases' => [
                'admin' => 'assets/{folder}/admin/',

            ]
        ]);

        $manager = Assets::add([]);

        $this->assertEquals(
            $manager->parsePathAlias('admin:index.js'),
            '/assets/js/admin/index.js'
        );

        $this->assertEquals(
            $manager->parsePathAlias('admin:index.css'),
            '/assets/css/admin/index.css'
        );
    }
}