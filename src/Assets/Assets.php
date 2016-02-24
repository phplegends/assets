<?php 

namespace PHPLegends\Assets;

use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\ImageCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Collections\CollectionInterface;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
class Assets
{
    /**
    * @static
    * @var array
    */
    protected static $config = [
        'compiled' => '_compiled',
        'path'     => '/',
        'base_uri' => '/',
    ];

    /**
    * @param array $config
    * @return void
    */
    public static function config(array $config)
    {
        static::$config = array_merge(static::$config, $config);
    }

    /**
    * @param string|array $assets
    * @param array $attributes
    * @return \PHPLegends\Assets\Manager
    */
    public static function image($assets, array $attributes = [])
    {
        $collection = (new ImageCollection)->setAttributes($attributes);

        return static::createManager()->addCollection($collection)->addArray((array) $assets);
    }

    /**
    * @param string|array $assets
    * @param array $attributes
    * @return \PHPLegends\Assets\Manager
    */
    public static function style($assets, array $attributes = [])
    {
        $collection = (new CssCollection)->setAttributes($attributes);

        return static::createManager()->addCollection($collection)->addArray((array) $assets);
    }

    /**
    * @param array $assets
    * @return \PHPLegends\Assets\Manager
    */
    public static function add(array $assets)
    {
        return  static::createManager()
                            ->addCollection(new CssCollection)
                            ->addCollection(new JavascriptCollection)
                            ->addArray($assets);
    }

    /**
    * @param string|array $assets
    * @param array $attributes
    * @return \PHPLegends\Assets\Manager
    */

    public static function script($assets, array $attributes = [])
    {
        $collection = (new JavascriptCollection)->setAttributes($attributes);

        return static::createManager()
                      ->addCollection($collection)
                      ->addArray((array) $assets);
    }


    /**
    * @param string|array $assets
    * @param string|null $filename
    * @return \PHPLegends\Assets\Manager
    */
    public static function concatScript(array $assets, $filename = null)
    {
        $manager = static::script($assets);

        $directory = static::buildCompileDirectory($manager->getBasePath());

        $files = $manager->getFilenames();

        $outputFile = Concatenator::create($files)
                                    ->setGlue(sprintf(';%s', PHP_EOL))
                                    ->getCache($directory, $filename);

        $concatOutput = static::$config['compiled'] . '/' . $outputFile->getFilename();

        return static::script($concatOutput);
    }

    /**
    * @param string|array $assets
    * @param string|null $filename
    * @return \PHPLegends\Assets\Manager
    */

    public static function concatStyle(array $assets, $filename = null)
    {
        $manager = static::style($assets);

        $directory = static::buildCompileDirectory();

        $files = $manager->getFilenames();

        $outputFile = (new Concatenator($files))->getCache($directory, $filename);

        $concatOutput = static::$config['compiled'] . '/' . $outputFile->getFilename();

        return static::style($concatOutput);
    }

    /**
    * @return string
    */
    protected static function buildCompileDirectory()
    {
        $directory = static::$config['path'] . '/' . static::$config['compiled'];

        if (! is_dir($directory)) {

            mkdir($directory, 0777, true);
        }

        return $directory;
    }

    /**
    * Creates and configure the manager
    * @return \PHPLegends\Assets\Manager
    */
    protected static function createManager()
    {
        $manager = new Manager;

        // Defines the nampesace globally

        if (isset(static::$config['base_uri'])) {

            $manager->setBaseUri(static::$config['base_uri']);
        }

        if (isset(static::$config['path'])) {

            $manager->setBasePath(static::$config['path']);

            // Trata o path para não haver barras desnecessárias

            static::$config['path'] = $manager->getBasePath();
        }

        if (isset(static::$config['path_aliases']) ) {

            foreach ((array) static::$config['path_aliases'] as $alias => $path) {

                $manager->addPathAlias($alias, $path);
            }   
        }

        if (isset(static::$config['version'])) {

            $manager->setVersion(static::$config['version']);
        }

        return $manager;
    }

}