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
    * @param string $asset
    * @return boolean
    */
    public function validateExtension($asset)
    {
        $regex = sprintf('/\.(%s)$/i', implode('|', $this->getExtensions()));

        return (boolean) preg_match($regex, $asset);
    }

    /**
    * @param string $asset
    * @return 
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

    public function addArray(array $assets)
    {
        foreach ($assets as $asset) $this->add($asset);

        return $this;
    }

    public function all()
    {
        return $this->items;
    }

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

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes + $this->attributes;

        return $this;
    }
}