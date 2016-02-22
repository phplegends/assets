<?php

namespace PHPLegends\Assets;

use SplFileObject;

class Concatenator
{
	protected $files;

	public function __construct(array $files)
	{
		if (empty($files)) {

			throw new \UnexpectedValueException("Error Processing Request", 1);
		}

		foreach ($files as $file) $this->add($file);

	}

	public function add($file)
	{
		if (! file_exists($file)) {

			throw new \UnexpectedValueException("File {$file} doesn't exists");
		}

		$this->files[] = $file;
	}

	public function save($path, $filename = null)
	{		

		$filename = ($filename) ? $filename : $this->generateFilename();

		$filename = rtrim($path, '/') . '/' . $filename;

		$newFile = new SplFileObject($filename, 'w');

		foreach ($this->files as $file) {

			$file = new SplFileObject($file, 'r');

			foreach ($file as $line) {

				$newFile->fwrite($line);
			}
		}

		return $newFile;

	}

	protected function generateFilename()
	{
		$extension = pathinfo(reset($this->files), PATHINFO_EXTENSION);

		return md5(implode('', $this->files)) . '.' . $extension;
	}
}