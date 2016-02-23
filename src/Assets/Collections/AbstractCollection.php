<?php

namespace PHPLegends\Assets\Collections;

abstract class AbstractCollection implements CollectionInterface
{

    /**
    * @var array
    */
    protected $attributes = [];

    /**
    * @var array
    */
    protected $items = [];

    /**
    * @{inheritdoc}
    */
    abstract public function getAssetAlias();

    /**
    * @{inheritdoc}
    */
    abstract public function buildTag($url);

    
    /**
    * @{inheritdoc}
    */
    public function validateExtension($asset)
    {
        $regex = sprintf('/\.(%s)$/i', implode('|', $this->getExtensions()));

        return (boolean) preg_match($regex, $asset);
    }

    
    /**
    * @{inheritdoc}
    */
    public function add($asset)
    {
        if (! $this->validateExtension($asset)) {

            throw new \UnexpectedValueException(
                sprintf('Invalid extension for "%s"', $this->getAssetAlias())
            );
        }
        
        $this->items[$asset] = $asset;

        return $this;
    }

    /**
    * @param array $assets
    * @return \PHPLegends\Assets\Collections\AbstractCollection
    */
    public function addArray(array $assets)
    {
        foreach ($assets as $asset) $this->add($asset);

        return $this;
    }

    /**
    * @{inheritdoc}
    */
    public function all()
    {
        return $this->items;
    }

    /**
    * @param array $attributes
    * @param string
    */
    protected function createHtmlAttributes(array $attributes)
    {
        $output = [];

        foreach ($attributes as $name => $attribute) {

            $attribute = htmlspecialchars($attribute);

            if (is_integer($name)) {

                $output[] = "{$attribute}";

                continue;
            }

            $output[] = "{$name}=\"{$attribute}\"";
        }

        return implode(' ', $output);
    }

    /**
    * @param array $attributes
    * @return \PHPLegends\Assets\Collections\AbstractCollection
    */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes + $this->attributes;

        return $this;
    }

    /**
    * Get attributes for tag build
    * @param array
    */
    public function getAttributes()
    {
        return $this->attributes;
    }
}