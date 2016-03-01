<?php 

namespace PHPLegends\Assets;

use PHPLegends\Assets\Collections\JavascriptCollection;
use PHPLegends\Assets\Collections\CssCollection;
use PHPLegends\Assets\Collections\CollectionInterface;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>]
* This class is a facade acessor to \PHPLegends\Assets\Manager
*
* @method \PHPLegends\Assets\Manager style(string $asset, array $attributes)
* @method \PHPLegends\Assets\Manager script(string $asset, array $attributes)
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
    * Alias for add|addArray method of Manager
    * @param array $assets
    * @return \PHPLegends\Assets\Manager
    */
    public static function add(array $assets)
    {
        return static::manager()->addArray($assets);
    }

    /**
    * Create Manager with storage static config
    * @static
    * @return \PHPLegends\Assets\Manager
    */
    public static function manager()
    {
        return Manager::createFromConfig(static::$config);
    }

    /**
    * Create a url for a any asset
    * @param string $url
    * @return string
    */

    public static function url($asset)
    {
        return Manager::createEmptyManagerFromConfig(static::$config)->url($asset);
    }

    /**
    * Return the method of \PHPLegends\Assets\Manager magically
    * @param string $method
    * @param array $arguments
    * @return mixed
    */
    public static function __callStatic($method, array $arguments)
    {
        $manager = static::manager();

        if (! method_exists($manager, $method)) {

            throw new BadMethodCallException(sprintf(
                    'The method "%s::%s" does not exists',
                    get_class($manager),
                    $method
                )
            );
        }

        $count_arguments = count($arguments);

        switch ($count_arguments) {

            case 0:
                $result = $manager->$method();
                break;
            case 1:
                $result = $manager->$method($arguments[0]);
                break;
            case 2:
                $result = $manager->$method($arguments[0], $arguments[1]);
                break;
            case 3:
                $result = $manager->$method($arguments[0], $arguments[1], $arguments[2]);
                break;
            case 4:
                $result = $manager->$method($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
                break;
            case 5:
                $result = $manager->$method($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4]);
                break;
            
            default:
                $result = call_user_func_array([$method, $method], $arguments);
                break;
        }

        return $result;
        
    }

}