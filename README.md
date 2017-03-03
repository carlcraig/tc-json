Tc Json
=======

> A JSON encode/decode helper with easier error handling for PHP 

Installation
------------

```shell
composer require tc/json
```

Usage
-----

```php
<?php

use Tc\Json\Json;
use Tc\Json\JsonException;

$data = [
    'foo' => 'bar',
];

$jsonString = Json::encode($data); // {"foo": "bar"}

$jsonDataObject = Json::decode($jsonString); // ( [foo] => bar )

$jsonDataArray = Json::decode($jsonString, true ); // ['foo' => 'bar']

$jsonData = Json::decode($jsonString, true); // ['foo' => 'bar']

try {
    Json::decode('{"foo"'); // invalid json string
} catch(JsonException $e) {
    echo $e->getMessage(); // description of error
}

```

License
-------

Tc Json is licensed with the MIT license.

See LICENSE for more details.
