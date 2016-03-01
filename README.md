## The PHPLegends\Assets Library

This library provides an easy way to includes your assets in the project.


Instalation:

```json
{ 
    "phplegends/assets" : "dev-master"
}
```

See the example of configuration

```php

include_once 'vendor/autoload.php';

use PHPLegends\Assets\Assets;

Assets::config([
    'path'     => __DIR__ . '/public', // Folder containing the assets file

    'base_uri' => '/public', // Base uri for asset. Can be used for another domains, for example

    'compiled' => '_compiled_assets', // folder used for concatenator

    'version'  => '1.0', //  Version added in assets to prevent browser cache
]);
```


Example with `version` option defined: 

```php

echo Assets::style(['css/default.css']);

echo Assets::script(['js/default.js', 'js/jquery.min.js'])

```

```html
<link href="/public/css/default.css?_version=1.0" rel="stylesheet" type="text/css"/>
<script src="/public/js/default.js?_version=1.0" type="text/javascript" ></script>
<script src="/public/js/jquery.min.css?_version=1.0" type="text/javascript"></script>

```

#Concatenator


In this Asset library, is possible concatenate javascript and css files. You can define the name of output optionally

See this example:

```php

echo Assets::concatStyle(['css/default.css', 'css/reset.css', 'css/normalize.css'], 'output.css');

echo Assets::concatStyle(['css/default.css', 'css/reset.css', 'css/normalize.css']);

echo Asset::concatScript(['js/default.js', 'js/app.js']);

```

```html

<link href="/public/_compiled_assets/output.css" rel="stylesheet" type="text/css" />

<link href="/public/_compiled_assets/1ad453afa3564564fab3445.css" rel="stylesheet" type="text/css" />

<script src="/public/_compiled_assets/1ad453afa3564564fab3445.js" type="text/javascript"></script>

```



#Alias for Paths


You can create simple alias for paths. 

Example:


```php

Assets::config([
   // ...
     'path_aliases' => [
           'css.bootstrap' => 'css/dist/bootstrap'
     ]
   // ...
]);

echo Assets::style('css.bootstrap:bootstrap.min.css');

```


The output:

```html
<link 
    href="/public/css/dist/bootstrap/bootstrap.min.css?_version=1.0" 
    rel="stylesheet" 
    type="text/css" 
/>

```


For the dinamic alias generate, you will can use `{folder}` wildcard

```php

Assets::config([
    'path_aliases' => [
        'admin.site'  => '{folder}/admin/site'
    ]
]);


echo Assets::style('admin.site:index.css');

echo Assets::script('admin.site:index.js');

```


Output:

```html
<link 
    href="/public/css/admin/site/index.css" 
    rel="stylesheet" type="text/css" 
/>

<script src="/public/js/admin/site/index.js" type="text/javascript"></script>

```
