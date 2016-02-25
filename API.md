
## Table of contents

- [\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)
- [\PHPLegends\Assets\Assets](#class-phplegendsassetsassets)
- [\PHPLegends\Assets\Concatenator](#class-phplegendsassetsconcatenator)
- [\PHPLegends\Assets\ImageResizer](#class-phplegendsassetsimageresizer)
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
| public | <strong>addArray(</strong><em>array</em> <strong>$assets</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em><br /><em>Add files according to order of elements</em> |
| public | <strong>addCollection(</strong><em>[\PHPLegends\Assets\Collections\CollectionInterface](#interface-phplegendsassetscollectionscollectioninterface)</em> <strong>$collection</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em> |
| public | <strong>addPathAlias(</strong><em>string</em> <strong>$name</strong>, <em>string</em> <strong>$directory</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em> |
| public | <strong>clear()</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em><br /><em>Erases all collections</em> |
| public | <strong>concatScript(</strong><em>string/array/array</em> <strong>$assets</strong>, <em>mixed/string/null</em> <strong>$filename=null</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| public | <strong>concatStyle(</strong><em>string/array/array</em> <strong>$assets</strong>, <em>mixed/string/null</em> <strong>$filename=null</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| public static | <strong>createFromConfig(</strong><em>array</em> <strong>$config</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em><br /><em>Creates and configure the manager via array options</em> |
| public | <strong>getBasePath()</strong> : <em>string</em> |
| public | <strong>getBaseUri()</strong> : <em>string</em> |
| public | <strong>getCompileDirectory()</strong> : <em>string</em><br /><em>Gets the compile directory</em> |
| public | <strong>getFilenames()</strong> : <em>array</em> |
| public | <strong>getIterator()</strong> : <em>\ArrayIterator</em><br /><em>Iterates with tags</em> |
| public | <strong>getPathAliases()</strong> : <em>array</em> |
| public | <strong>getTags()</strong> : <em>array</em> |
| public | <strong>getUrls()</strong> : <em>array</em> |
| public | <strong>getVersion()</strong> : <em>string</em> |
| public | <strong>image(</strong><em>mixed</em> <strong>$assets</strong>, <em>array</em> <strong>$attributes=array()</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em><br /><em>Clone the manager to create a manager (width the current configuration) of only image</em> |
| public | <strong>imageResize(</strong><em>mixed</em> <strong>$assets</strong>, <em>array</em> <strong>$attributes=array()</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em><br /><em>Resize the images of only image</em> |
| public | <strong>mixed(</strong><em>array</em> <strong>$assets</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em><br /><em>Clone the manager to create a manager (width the current configuration) of only javascripts and stylesheets</em> |
| public | <strong>output()</strong> : <em>string</em> |
| public | <strong>parsePathAlias(</strong><em>string</em> <strong>$path</strong>)</strong> : <em>string</em> |
| public | <strong>script(</strong><em>string/array</em> <strong>$assets</strong>, <em>array</em> <strong>$attributes=array()</strong>)</strong> : <em>void</em><br /><em>Creates a clone of this manager (to mantains the same configuraions), with only JavascriptCollection</em> |
| public | <strong>setBasePath(</strong><em>string</em> <strong>$path</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em> |
| public | <strong>setBaseUri(</strong><em>string</em> <strong>$uri</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em> |
| public | <strong>setCompileDirectory(</strong><em>string</em> <strong>$directory</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em><br /><em>Sets the directory for story the compilations (for example, the concatenations)</em> |
| public | <strong>setVersion(</strong><em>string/\PHPLegends\Assets\callable</em> <strong>$version</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em><br /><em>Defines the version of assets</em> |
| public | <strong>style(</strong><em>string/array</em> <strong>$assets</strong>, <em>array</em> <strong>$attributes=array()</strong>)</strong> : <em>void</em><br /><em>Creates a clone of this manager (to mantains the same configuraions), with only CssCollection</em> |
| protected | <strong>buildCompileDirectory()</strong> : <em>string</em><br /><em>Build the directory name of the compile. If directory not exists, it's created.</em> |
| protected | <strong>buildUrl(</strong><em>mixed</em> <strong>$asset</strong>)</strong> : <em>string</em> |
| protected | <strong>buildVersion(</strong><em>string</em> <strong>$asset</strong>)</strong> : <em>string/null</em><br /><em>Build the version of the asset. If callable is given, the arguments are full filename and this instance</em> |
| protected | <strong>collectionToMappedList(</strong><em>\callable</em> <strong>$callback</strong>)</strong> : <em>array</em> |
| protected | <strong>extractPathAlias(</strong><em>string</em> <strong>$path</strong>)</strong> : <em>array</em> |
| protected | <strong>findCollectionByFileExtension(</strong><em>string</em> <strong>$asset</strong>)</strong> : <em>\PHPLegends\Assets\PHPLegends\Assets\Manager</em> |
| protected | <strong>parsePathWildcards(</strong><em>string</em> <strong>$path</strong>, <em>string</em> <strong>$asset</strong>)</strong> : <em>string</em> |

*This class implements \IteratorAggregate, \Traversable*

<hr /> 
### Class: \PHPLegends\Assets\Assets

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>__callStatic(</strong><em>string</em> <strong>$method</strong>, <em>array</em> <strong>$arguments</strong>)</strong> : <em>mixed</em><br /><em>Return the method of \PHPLegends\Assets\Manager magically</em> |
| public static | <strong>add(</strong><em>array</em> <strong>$assets</strong>)</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em><br /><em>Alias for add|addArray method of Manager</em> |
| public static | <strong>config(</strong><em>array</em> <strong>$config</strong>)</strong> : <em>void</em> |
| public static | <strong>manager()</strong> : <em>[\PHPLegends\Assets\Manager](#class-phplegendsassetsmanager)</em><br /><em>Create Manager with storage static config</em> |

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
| protected | <strong>isExpiredCache(</strong><em>string</em> <strong>$filename</strong>)</strong> : <em>boolean</em> |

<hr /> 
### Class: \PHPLegends\Assets\ImageResizer

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$image</strong>, <em>float</em> <strong>$height</strong>, <em>mixed/float/null</em> <strong>$width=null</strong>)</strong> : <em>void</em> |
| public static | <strong>create(</strong><em>mixed</em> <strong>$file</strong>, <em>float</em> <strong>$height</strong>, <em>mixed/float/null</em> <strong>$width=null</strong>)</strong> : <em>[\PHPLegends\Assets\ImageResizer](#class-phplegendsassetsimageresizer)</em> |
| public | <strong>getCache(</strong><em>string</em> <strong>$directory</strong>, <em>mixed/string/null</em> <strong>$filename=null</strong>)</strong> : <em>\SplFileObject</em> |
| public | <strong>save(</strong><em>string</em> <strong>$directory</strong>, <em>mixed/string/null</em> <strong>$filename=null</strong>)</strong> : <em>\SplFileObject</em> |
| protected | <strong>buildFilename(</strong><em>string</em> <strong>$directory</strong>, <em>mixed/string/null</em> <strong>$filename=null</strong>)</strong> : <em>string</em> |
| protected | <strong>generateFilename()</strong> : <em>string</em><br /><em>Generate a filename</em> |
| protected | <strong>getExtension()</strong> : <em>string</em><br /><em>Gets the extension of image</em> |
| protected | <strong>isExpiredCache(</strong><em>string</em> <strong>$destiny</strong>)</strong> : <em>boolean</em><br /><em>Is Expired cache of image?</em> |

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
| public | <strong>abstract buildTag(</strong><em>mixed</em> <strong>$url</strong>)</strong> : <em>void</em> |
| public | <strong>abstract getAssetAlias()</strong> : <em>mixed</em> |
| public | <strong>getAttributes()</strong> : <em>mixed</em><br /><em>Get attributes for tag build</em> |
| public | <strong>map(</strong><em>\callable</em> <strong>$callback=null</strong>)</strong> : <em>void</em> |
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
| public | <strong>buildTag(</strong><em>mixed</em> <strong>$asset</strong>)</strong> : <em>string</em><br /><em>Retrieves the content tag with url of asset</em> |
| public | <strong>getAssetAlias()</strong> : <em>string</em><br /><em>Retrieves the alias of collection</em> |
| public | <strong>getExtensions()</strong> : <em>array</em><br /><em>Get all extension accept by collection</em> |
| public | <strong>map(</strong><em>\callable</em> <strong>$callback=null</strong>)</strong> : <em>array</em><br /><em>Map all items</em> |
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



- [See the API for this package](https://github.com/phplegends/assets/blob/master/API.md)