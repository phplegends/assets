<?php

namespace PHPLegends\Assets\Collections;

class JavascriptCollection extends AbstractCollection
{
	protected $attributes = ['type' => 'text/javascript'];

	public function getAssetAlias()
	{
		return 'js';
	}

	public function buildTag($asset)
	{
		$attributes = ['src' => $asset] + $this->getAttributes();

		$attr = $this->createHtmlAttributes($attributes);

		return "<script {$attr}></script>";
	}

	public function getExtensions()
	{
		return ['js'];
	}
} 
