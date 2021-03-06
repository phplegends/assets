<?php

include __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Assets;
use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Collections;

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
            '<link href="/assets/css/home/index.css" rel="stylesheet" type="text/css" />'
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

        $manager = Assets::manager();

        $this->assertEquals(
            $manager->parsePathAlias('admin:index.js'),
            '/assets/js/admin/index.js'
        );

        $this->assertEquals(
            $manager->parsePathAlias('admin:index.css'),
            '/assets/css/admin/index.css'
        );
    }

    public function testPathAliasNonStatic()
    {

        $manager = new Manager([
            new Collections\JavascriptCollection,
            new Collections\CssCollection,
            new TestCollection,
        ]);


        $manager->addPathAlias('admin', 'assets/{folder}/admin');

        $manager->addPathAlias('css.admin', 'assets/css/admin');

        $tests = [
            'admin:index.js'        => '/assets/js/admin/index.js',
            'admin:doc.pdf'         => '/assets/test/admin/doc.pdf',
            'css.admin:default.css' => '/assets/css/admin/default.css',
        ];

        foreach ($tests as $fakename => $realname) {
            $this->assertEquals(
                $manager->parsePathAlias($fakename),
                $realname
            );
        }

    }

    public function testCollectionType()
    {
        $js = new Collections\JavascriptCollection;

        $css = new Collections\JavascriptCollection;

        $this->assertTrue($js instanceof Collections\CollectionInterface, 'The class "js" is not instance of CollectionInterface');

        $this->assertTrue($css instanceof Collections\CollectionInterface, 'The class "js" is not instance of CollectionInterface');

    }


    public function testUrl()
    {

        $manager = Assets::config([
            'compiled' => '_compiled/',
            'path'     => __DIR__ . '/../test/assets',
            'base_uri' => 'http://localhost:8000/assets',
            'path_aliases' => [
                'logos' => 'img/logos'
            ],

            // Be careful, in PHP, float 1.0 are converted to "1"
            'version' => '1.0',
        ]);

        $url = Assets::url('logos:default.png');

        $this->assertEquals(
            'http://localhost:8000/assets/img/logos/default.png?_version=1.0',
            $url
        );

    }

}

class TestCollection implements Collections\CollectionInterface
{
    protected $items;

    public function add($asset)
    {
        $this->items[] = $asset;
    }

    public function buildTag($url)
    {
        return "<iframe src='$url'></iframe>";
    }

    public function getAssetAlias()
    {
        return 'test';
    }

    public function validateExtension($asset)
    {
        return true;
    }

    public function getExtensions()
    {
        return ['txt', 'pdf'];
    }

    public function map(callable $callback = null)
    {
        return $this->items;
    }

}