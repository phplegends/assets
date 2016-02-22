<?php

namespace PHPLegends\Assets\Collections;

class JavascriptCollection extends AbstractCollection
{
	public function getAssetAlias()
	{
		return 'js';
	}

	public function buildTag($url, array $attributes = [])
	{
		return "<script type='text/javascript' src='{$url}'></script>";
	}

	public function getExtensions()
	{
		return ['js'];
	}
} 
