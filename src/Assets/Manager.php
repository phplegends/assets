<?php

namespace PHPLegends\Assets;


use PHPLegends\Assets\Collections\CollectionInterface;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\ImageCollection;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
* @see {@link https://github.com/phplegends/assets/blob/master/API.md#class-phplegendsassetsmanager}
*/
class Manager implements \IteratorAggregate
{
    /**
    * @var array
    */
    protected $collections = [];

    /**
    * @var
    */
    protected $paths = [];

    /**
    * @var string
    */
    protected $baseUri;

    /**
    * @var string
    */
    protected $basePath;

    /**
    * @var string|callable
    */
    protected $version;


    /**
    * @param \PHPLegends\Assets\Collections\CollectionInterface[] $collections
    * @return void
    */
    public function __construct(array $collections = [])
    {
        foreach ($collections as $collection) {

            $this->addCollection($collection);

        }
    }

    /**
    * @param \PHPLegends\Assets\Collections\CollectionInterface $collection
    * @return PHPLegends\Assets\Manager
    */
    public function addCollection(CollectionInterface $collection)
    {
        $this->collections[$collection->getAssetAlias()] = $collection;

        return $this;
    }

    /**
    * @param string $name
    * @param string $directory
    * @return PHPLegends\Assets\Manager
    */
    public function addPathAlias($name, $directory)
    {
        $this->paths[$name] = '/' . trim($directory, '/');

        return $this;
    }

    /**
    * @return array
    */
    public function getPathAliases()
    {
        return $this->paths;
    }
    
    /**
    * @param string $asset
    * @return PHPLegends\Assets\Manager
    */
    public function add($asset)
    {

        $collection = $this->findCollectionByFileExtension($asset);

        $asset = $this->parsePathAlias($asset);

        $collection->add($asset);

        return $this;
    }

    /**
    * Add files according to order of elements
    * @param array $assets
    * @return PHPLegends\Assets\Manager
    */
    public function addArray(array $assets)
    {

        foreach ($assets as $asset) $this->add($asset);

        return $this;
    }

    /**
    * @param string $asset
    * @return PHPLegends\Assets\Manager
    **/
    protected function findCollectionByFileExtension($asset)
    {

        foreach ($this->collections as $collection) {

            if ($collection->validateExtension($asset)) {

                return $collection;
            }
        }

        $message =  sprintf(
            'The collection of extension "%s" is not registred',
            pathinfo($asset, PATHINFO_EXTENSION)
        );

        throw new \InvalidArgumentException($message);
        
        return null;
    }

    /**
    * @return array
    */
    public function getTags()
    {
        return $this->collectionToMappedList(function ($item, $collection)
        {
            return $collection->buildTag($this->buildUrl($item));
        });
    }

    /**
    * @return array
    */
    public function getFilenames()
    {
        return $this->collectionToMappedList(function($item, $collection)
        {
            return $this->getBasePath() . $item;
        });
    }

    /**
    * @return array
    */
    public function getUrls()
    {
        return $this->collectionToMappedList(function ($item) {

            return $this->buildUrl($item);
        });
    }

    /**
    * @param string $uri
    * @return PHPLegends\Assets\Manager
    */
    public function setBaseUri($uri)
    {
        $this->baseUri = rtrim($uri, '/');

        return $this;
    }

    /**
    * @return string
    */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
    * @param string $path
    * @return \PHPLegends\Assets\Manager
    */
    public function setBasePath($path)
    {
        $realpath = realpath($path);

        if ($realpath === false) {

            throw new \InvalidArgumentException("The base path '{$path}' doesn't exists");
        }

        $this->basePath = rtrim($realpath, '/');

        return $this;
    }

    /**
    * @return string
    */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
    * @return string
    */
    public function output()
    {
        return implode(PHP_EOL, $this->getTags());
    }

    /**
    * yes! this returns a string
    * @return string
    */
    public function __toString()
    {
        return $this->output();
    }

    /**
    * @param callable $callback
    * @return array
    */
    protected function collectionToMappedList(callable $callback)
    {
        $items = [];

        foreach ($this->collections as $collection) {

            $items = array_merge(
                $items, $collection->map($callback)
            );
        }

        return $items;
    }

    /**
    * @param string $path
    * @return array
    */
    protected function extractPathAlias($path)
    {
        $separator = ':';

        if (strpos($path, $separator) === false) {

            return [null, $path];
        }

        return explode($separator, $path);
    }

    /**
    * @param string $path
    * @return string
    */
    public function parsePathAlias($path)
    {
        list($alias, $asset) = $this->extractPathAlias($path);

        $asset = '/'. ltrim($asset, '/');

        if ($alias === null) return $asset;

        if (! isset($this->paths[$alias])) {

            throw new \UnexpectedValueException(
                "Alias with name '{$alias}' doesn't registred"
            );
        }

        $path = $this->paths[$alias];

        $path = $this->parsePathWildcards($path, $asset);

        return $path . $asset;
    }

    /**
    * @param string $path
    * @param string $asset
    * @return string
    */
    protected function parsePathWildcards($path, $asset)
    {
        $collection = $this->findCollectionByFileExtension($asset);

        return strtr($path, ['{folder}' => $collection->getAssetAlias()]);
    }

    /**
    * Defines the version of assets
    * @param string|callable $version
    * @return \PHPLegends\Assets\Manager
    */
    public function setVersion($version)
    {

        $this->version = $version;

        return $this;
    }

    /**
    * @return string
    */
    public function getVersion()
    {
        return $this->version;
    }

    /**
    * @return string
    */
    protected function buildUrl($asset)
    {
        $version = $this->buildVersion($asset);

        if ($version !== null) {

            $asset .= '?' . http_build_query(['_version' => $version]);
        }

        return $this->getBaseUri() . $asset;
    }

    /**
    * Build the version of the asset. 
    * If callable is given, the arguments are full filename and this instance
    * @param string $asset
    * @return string|null
    */
    protected function buildVersion($asset)
    {
        $version = $this->getVersion();

        if (is_callable($version)) {

            $version = $version($this->getBasePath() . $asset, $this);
        }

        return $version;
    }

    /**
    * Erases all collections
    * @return \PHPLegends\Assets\Manager
    **/
    public function clear()
    {
        $this->collections = [];

        return $this;
    }

    /**
    * Clone the manager to create a manager (width the current configuration)
    * of only javascripts and stylesheets
    * @param array $assets
    * @return \PHPLegends\Assets\Manager
    */
    public function mixed(array $assets)
    {
        $manager = clone $this;

        $manager->clear()
                ->addCollection(new CssCollection)
                ->addCollection(new JavascriptCollection)
                ->addArray($assets);

        return $manager;
    }

    /**
    * Clone the manager to create a manager (width the current configuration)
    * of only image
    * @return \PHPLegends\Assets\Manager
    */
    public function image($assets, array $attributes = [])
    {

        $manager = clone $this;

        $collection = (new ImageCollection)->setAttributes($attributes);

        $manager->clear()
                ->addCollection($collection)
                ->addArray((array) $assets);

        return $manager;

    }

    /**
    * Resize the images
    * of only image
    * @return \PHPLegends\Assets\Manager
    */
    public function imageResize($assets, array $attributes = [])
    {
        if (! isset($attributes['height'])) {

            throw new \InvalidArgumentException('The argumento #height is required in attributes array');
        }

        $height = $attributes['height'];

        $width = isset($attributes['width']) ? $attributes['width'] : null;

        $images = [];

        $directory = $this->buildCompileDirectory();

        foreach ($this->image($assets)->getFilenames() as $file) {

            $outputFile = ImageResizer::create($file, $height, $width)
                                ->getCache($directory)
                                ->getFilename();

            $images[] = $this->getCompileDirectory() . '/' . $outputFile;
        }

        return $this->image($images, $attributes);
    }

    /**
    * Creates a clone of this manager (to mantains the same configuraions),
    * with only CssCollection
    *
    * @param string|array $assets
    * @param array $attributes
    * @param string|array $assets
    */
    public function style($assets, array $attributes = [])
    {

        $manager = clone $this;

        $collection = (new CssCollection)->setAttributes($attributes);

        $manager->clear()
                ->addCollection($collection)
                ->addArray((array) $assets);

        return $manager;
    }


    /**
    * Creates a clone of this manager (to mantains the same configuraions),
    * with only JavascriptCollection
    *
    * @param string|array $assets
    * @param array $attributes
    * @param string|array $assets
    */
    public function script($assets, array $attributes = [])
    {

        $manager = clone $this;

        $collection = (new JavascriptCollection)->setAttributes($attributes);

        $manager->clear()
                ->addCollection($collection)
                ->addArray((array) $assets);

        return $manager;
    }

    /**
    * Sets the directory for story the compilations (for example, the concatenations)
    * @param string $directory
    * @return \PHPLegends\Assets\Manager
    */
    public function setCompileDirectory($directory)
    {
        $this->compiledDirectory = rtrim($directory, '/');

        return $this;
    }

    /**
    * Gets the compile directory
    * @return string
    */
    public function getCompileDirectory()
    {
        return $this->compiledDirectory;
    }


    /**
    * Build the directory name of the compile. If directory not exists, it's created.
    * @return string
    */
    protected function buildCompileDirectory()
    {
        $directory = $this->getBasePath() . '/' . $this->getCompileDirectory();

        if (! is_dir($directory)) mkdir($directory, 0777, true);

        return $directory;
    }

    /**
    * @param string|array $assets
    * @param string|null $filename
    * @return \PHPLegends\Assets\Manager
    */
    public function concatScript(array $assets, $filename = null)
    {
        $manager = $this->script($assets);

        $directory = $this->buildCompileDirectory();

        $files = $manager->getFilenames();

        $outputFile = Concatenator::create($files)
                                    ->setGlue(';')
                                    ->getCache($directory, $filename);

        $concatOutput = $this->getCompileDirectory() . '/' . $outputFile->getFilename();

        return $this->script($concatOutput);
    }

    /**
    * @param string|array $assets
    * @param string|null $filename
    * @return \PHPLegends\Assets\Manager
    */

    public function concatStyle(array $assets, $filename = null)
    {
        $manager = $this->style($assets);

        $directory = $this->buildCompileDirectory();

        $files = $manager->getFilenames();

        $outputFile = Concatenator::create($files)->getCache($directory, $filename);

        $concatOutput = $this->getCompileDirectory() . '/' . $outputFile->getFilename();

        return $this->style($concatOutput);
    }

    
    /**
    * Creates and configure the manager via array options
    * @return \PHPLegends\Assets\Manager
    */
    public static function createFromConfig(array $config)
    {
        $manager = new self([
            new CssCollection,
            new JavascriptCollection,
            new ImageCollection
        ]);

        if (isset($config['base_uri'])) {

            $manager->setBaseUri($config['base_uri']);
        }

        if (isset($config['path'])) {

            $manager->setBasePath($config['path']);
        }

        if (isset($config['path_aliases']) && is_array($config['path_aliases'])) {

            foreach ($config['path_aliases'] as $alias => $path) {

                $manager->addPathAlias($alias, $path);
            }   
        }

        if (isset($config['compiled'])) {

            $manager->setCompileDirectory($config['compiled']);
        }

        if (isset($config['version'])) {

            $manager->setVersion($config['version']);
        }

        return $manager;
    }

    /**
    * Iterates with tags
    * @return \ArrayIterator
    */
    public function getIterator()
    {
        return new \ArrayIterator($this->getTags());
    }

}

