Yii2 extension for Sypex Geo API (http://sypexgeo.net)
======================================================

This extension adds support for Sypex Geo to the Yii2 framework

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist sbs/yii2-sypexgeo "*"
```

or add

```json
"sbs/yii2-sypexgeo": "^1.0"
```

to the `require` section of your composer.json.

What it is all about?
---------------------

Sypex Geo - product for location by IP address. Obtaining the IP address, Sypex Geo outputs information about 
the location of the visitor - country, region, city, geographical coordinates and other in Russian and in English. 
Sypex Geo use local compact binary database file and works very quickly. 
For more information visit: http://sypexgeo.net/

This is extension for Yii2 framework that makes it easy to deal with Sypex Geo.

Usage
-----
Unfortunately, original version of Sypex Geo does not support Composer installation, so we have to include it into
this extension.

First of all, you have to download desired database from the http://sypexgeo.net/ website and place it somewhere
on your server.

There are two classes in this extension.

**SypexGeo** - this is the component can be used to retrieve Geo information based on IP address. 
Component encapsulates calls to the SxGeo methods.

You can use it as an application component:

```php
// config.php
[
    'components' => [
        'sypexGeo' => [
            'class' => 'sbs\components\SypexGeo',
            'database' => '@app/data/SxGeoCity.dat',
        ]
    ]
]

// somewhere in your code
$city = Yii::$app->sypexGeo->getCity($ip);
```

Also, you can create an instance by yourself:

```php
use sbs\components\SypexGeo;
// ...
$sypexGeo = new SypexGeo([
    'database' => '@app/data/SxGeoCity.dat',
]);
$city = $sypexGeo->getCity($ip);
```

**GeoBehavior** - behavior that can be attached to the `yii\web\Request` or it's children and this class adds methods
to simplify getting Geo information for current request.
 
Example:

```php
// config.php
[
    'components' => [
        'request' => [
            'as sypexGeo' => [
                'class' => 'sbs\behaviors\GeoBehavior',
                // It is not required property if you have SypexGeo component defined in your application
                'config' => [
                    'database' => '@app/data/SxGeoCity.dat',
                ]
            ]
        ]
    ],
]

// In your code
$city = Yii::$app->request->getCity();

```
