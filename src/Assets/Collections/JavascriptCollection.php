<?php

namespace PHPLegends\Assets\Collections;

class JavascriptCollection extends AbstractCollection
{
	public function getExtension()
	{
		return 'js';
	}

	public function buildTag($url)
	{
		return "<script type='text/javascript' src='{$url}'></script>";
	}
} 
