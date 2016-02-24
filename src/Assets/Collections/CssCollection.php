<?php

namespace PHPLegends\Assets\Collections;

class CssCollection extends AbstractCollection
{
    protected $attributes = [
        'rel' => 'stylesheet',
        'type' => 'text/css'
    ];

    public function getAssetAlias()
    {
        return 'css';
    }

    public function buildTag($url)
    {
        
        $attributes = ['href' => $url] + $this->getAttributes();

        $attr = $this->createHtmlAttributes($attributes);

        return "<link {$attr}/>";
    }

    public function getExtensions()
    {
        return ['css'];
    }
}