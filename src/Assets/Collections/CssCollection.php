<?php

namespace PHPLegends\Assets\Collections;

class CssCollection extends AbstractCollection
{
	public function getAssetAlias()
	{
		return 'css';
	}

	public function buildTag($url, array $attributes = [])
	{
		return "<link rel='stylesheet' type='text/css' href='{$url}' />";
	}

	public function getExtensions()
	{
		return ['css'];
	}
}