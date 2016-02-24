<?php

namespace PHPLegends\Assets;

use SplFileObject;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
* File concatenator class
*/
class Concatenator
{

    /**
    * @var array
    */
    protected $files;

    /**
    * @var string|null
    */
    protected $glue = PHP_EOL;

    /**
    * @param array $files
    * @return void
    */
    public function __construct(array $files)
    {
        if (empty($files)) {

            throw new \UnexpectedValueException("The argument \$files cannot be empty", 1);
        }

        foreach ($files as $file) $this->add($file);

    }

    /**
    * @param string $file
    * @return \PHPLegends\Assets\Concatenator
    */
    public function add($file)
    {

        if (! file_exists($file)) {

            throw new \UnexpectedValueException("File {$file} doesn't exists");
        }

        $this->files[] = $file;

        return $this;
    }

    /**
    * @param string $glue
    * @return \PHPLegends\Assets\Concatenator
    */
    public function setGlue($glue)
    {
        $this->glue = $glue;

        return $this;
    }

    /**
    * @param string $path
    * @param string|null $filename
    * @return \SplFileObject
    */
    public function getCache($path, $filename = null)
    {
        $cachedfile = $this->buildFilename($path, $filename);

        if (! file_exists($cachedfile) || $this->isCacheExpired($cachedfile))
        {
            $this->save($path, $filename);
        }

        return new \SplFileObject($cachedfile, 'r');

    }

    /**
    * @param string $path
    * @param string|null $filename
    * @return \SplFileObject
    */
    public function save($path, $filename = null)
    {       

        $filename = $this->buildFilename($path, $filename);

        $newFile = new SplFileObject($filename, 'w');

        foreach ($this->files as $file) {

            $file = new SplFileObject($file, 'r');

            $file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

            foreach ($file as $line) {

                $newFile->fwrite($line . PHP_EOL);
            } 

            if (substr($line, -1) !== $this->glue) {

                $newFile->fwrite($this->glue);
            }
        }

        return $newFile;

    }

    /**
    * @return string
    */
    protected function generateFilename()
    {
        $extension = pathinfo(reset($this->files), PATHINFO_EXTENSION);

        return md5(implode('', $this->files)) . '.' . $extension;
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
    * @param string $filename
    * @return boolean
    */
    protected function isCacheExpired($filename)
    {

        $modified = filemtime($filename);

        foreach ($this->files as $file)
        {
            if (filemtime($file) > $modified) {

                return true;
            }
        }

        return false;

    }

    /**
    * @param array $files
    * @return \PHPLegends\Assets\Concatenator
    */
    public static function create(array $files)
    {
        return new self($files);
    }
}