<?php

include __DIR__ . '/../vendor/autoload.php';

use PHPLegends\Assets\Assets;
use PHPLegends\Assets\Manager;
use PHPLegends\Assets\Collections;

class ManagerTest extends PHPUnit_Framework_TestCase
{ 
    // tdd

    public function __construct()
    {
        $this->manager = new Manager;
    }
    public function testInstance()
    {
        

        $this->manager->addPathAlias('admin', 'assets/{folder}/admin');

        $tests = [
            'style' => ['admin:teste.css', '<link href="/assets/css/admin/teste.css" rel="stylesheet" type="text/css" />'],
            'script'=> ['admin:teste.js', '<script src="/assets/js/admin/teste.js" type="text/javascript"></script>']
        ];

        foreach ($tests as $method => $param) {

            list($asset, $expected) = $param;

            $result = (string) $this->manager->$method($asset);

            $this->assertEquals(
                $expected,
                $result,
                "assertion error to {$method}"
            );
        }

    }


    public function testConcatScript()
    {

        // Skip default confings

        $manager = new Manager;

        $manager->setBasePath(__DIR__ . '/../test/assets/');

        $manager->setBaseUri('/assets');

        $manager->setCompileDirectory('_compiled_created_by_phpunit_test');

        $manager->addPathAlias('admin', '{folder}/admin');

        $anotherManager = $manager->concatScript(['admin:teste.js', 'admin:default.js'], 'output.js');

        $this->assertEquals(
            '<script src="/assets/_compiled_created_by_phpunit_test/output.js" type="text/javascript"></script>',
            (string) $anotherManager
        );  

        $anotherManager = $manager->concatStyle(['css/default.css', 'css/reset.css'], 'output.css');

        $this->assertEquals(
            '<link href="/assets/_compiled_created_by_phpunit_test/output.css" rel="stylesheet" type="text/css" />',
            (string) $anotherManager
        );  


    }


    public function testMixin()
    {

        // Skip default confings

        $manager = new Manager;

        $manager->setBasePath(__DIR__ . '/../test/assets/');

        $manager->setBaseUri('/assets');

        $manager->setCompileDirectory('_compiled');

        $manager->addPathAlias('admin', '{folder}/admin');

        //$manager->setVersion(1.0);

        $result = 
            '<link href="/assets/css/admin/default.css" rel="stylesheet" type="text/css" />' . PHP_EOL .
            '<script src="/assets/js/default.js" type="text/javascript"></script>';

        $expected = $manager->mixed(['js/default.js', 'admin:default.css']);

        $this->assertEquals(
            $result,
            $expected->output()
            
        );
    }

    public function testCreateFromConfig()
    {

        $manager = Manager::createFromConfig([
            'compiled' => '_compiled/',
            'path'     => __DIR__ . '/../test/assets',
            'base_uri' => 'http://localhost:8000/assets',
            'path_aliases' => [
                'admin' => '{folder}/admin',
            ],
            'version' =>  function ($file)
            {
                return is_file($file) ?  md5_file($file) : '1.0';
            }
        ]);

        // Check the return

        $this->assertTrue($manager instanceof Manager);


        $this->assertEquals(
            'http://localhost:8000/assets',
            $manager->getBaseUri()
        );

        // The last blackslash are cleaned. Testing

        $this->assertEquals(
            '_compiled',
            $manager->getCompileDirectory()
        );


        $this->assertArrayHasKey(
            'admin',
            $manager->getPathAliases(),
            'The array not contain "admin"'
        );


    }

    public function testGetUrls()
    {
        $manager = Manager::createFromConfig([
            'compiled' => '_compiled/',
            'path'     => __DIR__ . '/../test/assets',
            'base_uri' => 'http://localhost:8000/assets',
            'path_aliases' => [
                'admin' => '{folder}/admin',
            ],
            'version' =>  function ($file)
            {
                return is_file($file) ?  md5_file($file) : '1.0';
            }
        ]);


        $manager->add('admin:default.js');

        $manager->add('admin:xxx.js');

        $manager->add('admin:xxx.css');

        // Css are ordened first than Javascriot
        
        $this->assertEquals(
            'http://localhost:8000/assets/js/admin/default.js?_version=3ee7ba0a657110425903181bcb0459c7',
            $manager->getUrls()[1]
        );
    }

}