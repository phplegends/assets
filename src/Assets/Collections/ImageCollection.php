<?php

namespace PHPLegends\Assets\Collections;

class ImageCollection extends AbstractCollection
{
	public function getAssetAlias()
	{
		return 'img';
	}

	public function buildTag($url, array $attributes = [])
	{
		return "<img src='{$url}' />";
	}

	public function getExtensions()
	{
		return ['jpg', 'png', 'bmp', 'jpeg'];
	}
}