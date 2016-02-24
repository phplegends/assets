## Table of contents

- [\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)
- [\PHPLegends\Assets\Assets](#class-phplegendsassetsassets)
- [\PHPLegends\Assets\Concatenator](#class-phplegendsassetsconcatenator)
- [\PHPLegends\Assets\Collections\CssCollection](#class-phplegendsassetscollectionscsscollection)
- [\PHPLegends\Assets\Collections\AbstractCollection (abstract)](#class-phplegendsassetscollectionsabstractcollection-abstract)
- [\PHPLegends\Assets\Collections\JavascriptCollection](#class-phplegendsassetscollectionsjavascriptcollection)
- [\PHPLegends\Assets\Collections\CollectionInterface (interface)](#interface-phplegendsassetscollectionscollectioninterface)
- [\PHPLegends\Assets\Collections\ImageCollection](#class-phplegendsassetscollectionsimagecollection)

<hr /> 
### Class: \PHPLegends\Assets\Manager

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array/[\PHPLegends\Assets\Collections\CollectionInterface](#interface-phplegendsassetscollectionscollectioninterface)[]</em> <strong>$collections=array()</strong>)</strong> : <em>void</em> |
| public | <strong>__toString()</strong> : <em>string</em><br /><em>yes! this returns a string</em> |
| public | <strong>add(</strong><em>string</em> <strong>$asset</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em> |
| public | <strong>addArray(</strong><em>array</em> <strong>$assets</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em> |
| public | <strong>addCollection(</strong><em>[\PHPLegends\Assets\Collections\CollectionInterface](#interface-phplegendsassetscollectionscollectioninterface)</em> <strong>$collection</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em> |
| public | <strong>addPathAlias(</strong><em>string</em> <strong>$name</strong>, <em>string</em> <strong>$directory</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em> |
| public | <strong>getBasePath()</strong> : <em>string</em> |
| public | <strong>getBaseUri()</strong> : <em>string</em> |
| public | <strong>getFilenames()</strong> : <em>array</em> |
| public | <strong>getTags()</strong> : <em>array</em> |
| public | <strong>getVersion()</strong> : <em>string</em> |
| public | <strong>output()</strong> : <em>string</em> |
| public | <strong>setBasePath(</strong><em>string</em> <strong>$path</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| public | <strong>setBaseUri(</strong><em>string</em> <strong>$uri</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em> |
| public | <strong>setVersion(</strong><em>string</em> <strong>$version</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| protected | <strong>buildUrl(</strong><em>mixed</em> <strong>$asset</strong>)</strong> : <em>string</em> |
| protected | <strong>collectionToMappedList(</strong><em>\callable</em> <strong>$callback</strong>)</strong> : <em>array</em> |
| protected | <strong>extractPathAlias(</strong><em>string</em> <strong>$path</strong>)</strong> : <em>array</em> |
| protected | <strong>findCollectionByFileExtension(</strong><em>string</em> <strong>$asset</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em> |
| protected | <strong>mapCollection(</strong><em>[\PHPLegends\Assets\Collections\CollectionInterface](#interface-phplegendsassetscollectionscollectioninterface)</em> <strong>$collection</strong>, <em>\callable</em> <strong>$callback</strong>)</strong> : <em>array</em> |
| protected | <strong>parsePathAlias(</strong><em>string</em> <strong>$path</strong>)</strong> : <em>string</em> |
| protected | <strong>parsePathWildcards(</strong><em>string</em> <strong>$path</strong>, <em>string</em> <strong>$asset</strong>)</strong> : <em>string</em> |

<hr /> 
### Class: \PHPLegends\Assets\Assets

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>add(</strong><em>array</em> <strong>$assets</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| public static | <strong>concatScript(</strong><em>string/array/array</em> <strong>$assets</strong>, <em>mixed/string/null</em> <strong>$filename=null</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| public static | <strong>concatStyle(</strong><em>string/array/array</em> <strong>$assets</strong>, <em>mixed/string/null</em> <strong>$filename=null</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| public static | <strong>image(</strong><em>string/array</em> <strong>$assets</strong>, <em>array</em> <strong>$attributes=array()</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| public static | <strong>script(</strong><em>string/array</em> <strong>$assets</strong>, <em>array</em> <strong>$attributes=array()</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| public static | <strong>setConfig(</strong><em>array</em> <strong>$config</strong>)</strong> : <em>void</em> |
| public static | <strong>style(</strong><em>string/array</em> <strong>$assets</strong>, <em>array</em> <strong>$attributes=array()</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| protected static | <strong>buildCompileDirectory()</strong> : <em>string</em> |
| protected static | <strong>createManager()</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em><br /><em>Creates and configure the manager</em> |

<hr /> 
### Class: \PHPLegends\Assets\Concatenator

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array</em> <strong>$files</strong>)</strong> : <em>void</em> |
| public | <strong>add(</strong><em>string</em> <strong>$file</strong>)</strong> : <em>[\PHPLegends\Assets\Concatenator](#class-phplegendsassetsconcatenator)</em> |
| public static | <strong>create(</strong><em>array</em> <strong>$files</strong>)</strong> : <em>[\PHPLegends\Assets\Concatenator](#class-phplegendsassetsconcatenator)</em> |
| public | <strong>getCache(</strong><em>string</em> <strong>$path</strong>, <em>mixed/string/null</em> <strong>$filename=null</strong>)</strong> : <em>\SplFileObject</em> |
| public | <strong>save(</strong><em>string</em> <strong>$path</strong>, <em>mixed/string/null</em> <strong>$filename=null</strong>)</strong> : <em>\SplFileObject</em> |
| public | <strong>setGlue(</strong><em>string</em> <strong>$glue</strong>)</strong> : <em>[\PHPLegends\Assets\Concatenator](#class-phplegendsassetsconcatenator)</em> |
| protected | <strong>buildFilename(</strong><em>mixed</em> <strong>$path</strong>, <em>mixed</em> <strong>$filename=null</strong>)</strong> : <em>string</em> |
| protected | <strong>generateFilename()</strong> : <em>string</em> |
| protected | <strong>isCacheExpired(</strong><em>string</em> <strong>$filename</strong>)</strong> : <em>boolean</em> |

<hr /> 
### Class: \PHPLegends\Assets\Collections\CssCollection

| Visibility | Function |
|:-----------|:---------|
| public | <strong>buildTag(</strong><em>mixed</em> <strong>$url</strong>)</strong> : <em>void</em> |
| public | <strong>getAssetAlias()</strong> : <em>mixed</em> |
| public | <strong>getExtensions()</strong> : <em>mixed</em> |

*This class extends [\PHPLegends\Assets\Collections\AbstractCollection](#class-phplegendsassetscollectionsabstractcollection-abstract)*

*This class implements [\PHPLegends\Assets\Collections\CollectionInterface](#interface-phplegendsassetscollectionscollectioninterface)*

<hr /> 
### Class: \PHPLegends\Assets\Collections\AbstractCollection (abstract)

| Visibility | Function |
|:-----------|:---------|
| public | <strong>add(</strong><em>mixed</em> <strong>$asset</strong>)</strong> : <em>void</em> |
| public | <strong>addArray(</strong><em>array</em> <strong>$assets</strong>)</strong> : <em>[\PHPLegends\Assets\Collections\AbstractCollection](#class-phplegendsassetscollectionsabstractcollection-abstract)</em> |
| public | <strong>all()</strong> : <em>void</em> |
| public | <strong>abstract buildTag(</strong><em>mixed</em> <strong>$url</strong>)</strong> : <em>void</em> |
| public | <strong>abstract getAssetAlias()</strong> : <em>mixed</em> |
| public | <strong>getAttributes()</strong> : <em>mixed</em><br /><em>Get attributes for tag build</em> |
| public | <strong>setAttributes(</strong><em>array</em> <strong>$attributes</strong>)</strong> : <em>[\PHPLegends\Assets\Collections\AbstractCollection](#class-phplegendsassetscollectionsabstractcollection-abstract)</em> |
| public | <strong>validateExtension(</strong><em>mixed</em> <strong>$asset</strong>)</strong> : <em>void</em> |
| protected | <strong>createHtmlAttributes(</strong><em>array</em> <strong>$attributes</strong>)</strong> : <em>mixed</em> |

*This class implements [\PHPLegends\Assets\Collections\CollectionInterface](#interface-phplegendsassetscollectionscollectioninterface)*

<hr /> 
### Class: \PHPLegends\Assets\Collections\JavascriptCollection

| Visibility | Function |
|:-----------|:---------|
| public | <strong>buildTag(</strong><em>mixed</em> <strong>$asset</strong>)</strong> : <em>void</em> |
| public | <strong>getAssetAlias()</strong> : <em>mixed</em> |
| public | <strong>getExtensions()</strong> : <em>mixed</em> |

*This class extends [\PHPLegends\Assets\Collections\AbstractCollection](#class-phplegendsassetscollectionsabstractcollection-abstract)*

*This class implements [\PHPLegends\Assets\Collections\CollectionInterface](#interface-phplegendsassetscollectionscollectioninterface)*

<hr /> 
### Interface: \PHPLegends\Assets\Collections\CollectionInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>add(</strong><em>string</em> <strong>$asset</strong>)</strong> : <em>[\PHPLegends\Assets\Collections\CollectionInterface](#interface-phplegendsassetscollectionscollectioninterface)</em><br /><em>Add asset file to collection</em> |
| public | <strong>all()</strong> : <em>array</em><br /><em>Get all items</em> |
| public | <strong>buildTag(</strong><em>mixed</em> <strong>$asset</strong>)</strong> : <em>string</em><br /><em>Retrieves the content tag with url of asset</em> |
| public | <strong>getAssetAlias()</strong> : <em>string</em><br /><em>Retrieves the alias of collection</em> |
| public | <strong>getExtensions()</strong> : <em>array</em><br /><em>Get all extension accept by collection</em> |
| public | <strong>validateExtension(</strong><em>string</em> <strong>$asset</strong>)</strong> : <em>boolean</em><br /><em>Validates the file extension of asset</em> |

<hr /> 
### Class: \PHPLegends\Assets\Collections\ImageCollection

| Visibility | Function |
|:-----------|:---------|
| public | <strong>buildTag(</strong><em>mixed</em> <strong>$asset</strong>)</strong> : <em>void</em> |
| public | <strong>getAssetAlias()</strong> : <em>mixed</em> |
| public | <strong>getExtensions()</strong> : <em>mixed</em> |

*This class extends [\PHPLegends\Assets\Collections\AbstractCollection](#class-phplegendsassetscollectionsabstractcollection-abstract)*

*This class implements [\PHPLegends\Assets\Collections\CollectionInterface](#interface-phplegendsassetscollectionscollectioninterface)*

