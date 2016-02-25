<?php

namespace PHPLegends\Assets;

use Gregwar\Image\Image as GregwarImage;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
* Note: This class is experimental
* Resize the image 
*/
class ImageResizer
{
    /**
    * Image to resize
    * @var string
    */
    protected $image;

    /**
    * @var float
    */
    protected $height;

    /**
    * @var float
    */
    protected $width;

    /**
    * @param string $image
    * @param float $height
    * @param float|null $width
    * @return void
    */
    public function __construct($image, $height, $width = null)
    {
        if (! file_exists($image)) {

            throw new \InvalidArgumentException("The file {$image} does not exists");

        }

        $this->image = $image;

        $this->height = $height;

        $this->width = $width;
    }

    /**
    * @param string $directory
    * @param string|null $filename
    * @return \SplFileObject
    */
    public function save($directory, $filename = null)
    {
        $destiny = $this->buildFilename($directory, $filename);

        GregwarImage::open($this->image)
                    ->resize($this->height, $this->width)
                    ->save($destiny, $this->getExtension());

        return new \SplFileObject($destiny, 'r');
    }

    /**
    * @param string $directory
    * @param string|null $filename
    * @return \SplFileObject
    */
    public function getCache($directory, $filename = null)
    {

        $destiny = $this->buildFilename($directory, $filename);

        if (! file_exists($destiny) || $this->isExpiredCache($destiny)) {

            return $this->save($directory, $filename);
        }

        return new \SplFileObject($destiny, 'r');
    }

    /**
    * @param 
    * @return string
    */
    protected function buildFilename($path, $filename = null)
    {
        $filename = ($filename) ? $filename : $this->generateFilename();

        $filename = rtrim($path, '/') . '/' . $filename;

        return $filename;
    }  

    /**
    * Gets the extension of image
    * @return string
    */
    protected function getExtension()
    {
        return pathinfo($this->image, PATHINFO_EXTENSION);
    }

    /**
    * Generate a filename
    */
    protected function generateFilename()
    {
        $md5 = md5($this->image . $this->height . $this->width);

        return $md5 . '.' . $this->getExtension();
    }

    /**
    * Is Expired cache of image?
    * @param string $destiny
    * @return boolean
    */
    protected function isExpiredCache($destiny)
    {
        return filemtime($this->image) > filemtime($destiny);
    }

    /**
    * @param string $image
    * @param float $height
    * @param float|null $width
    * @return \PHPLegends\Assets\ImageResizer
    */
    public static function create($file, $height, $width = null)
    {
        return new self($file, $height, $width);
    }
}