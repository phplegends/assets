<?php

namespace PHPLegends\Assets\Collections;

class CssCollection extends AbstractCollection
{
	public function getExtension()
	{
		return 'css';
	}

	public function buildTag($url)
	{
		return "<link rel='stylesheet' type='text/css' href='{$url}' />";
	}
}