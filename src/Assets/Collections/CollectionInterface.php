<?php

namespace PHPLegends\Assets\Collections;

interface CollectionInterface
{

    public function add($file);

    public function addNamespace($name, $dirname);

    public function getExtension();

    public function getTags();
    
    public function getUrls();
}