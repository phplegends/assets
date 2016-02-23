<?php

namespace PHPLegends\Assets\Collections;

class ImageCollection extends AbstractCollection
{

    public function getAssetAlias()
    {
        return 'img';
    }

    public function buildTag($asset)
    {
        $attributes = ['src' => $asset] + $this->getAttributes();

        $attr = $this->createHtmlAttributes($attributes);

        return "<img {$attr}/>";
    }

    public function getExtensions()
    {
        return ['jpg', 'png', 'bmp', 'jpeg'];
    }
}