# yii2-yml-catalog

[![Build Status](https://travis-ci.org/pastuhov/yii2-yml-catalog.svg)](https://travis-ci.org/pastuhov/yii2-yml-catalog)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/?branch=master)
[![Total Downloads](https://poser.pugx.org/pastuhov/yii2-yml-catalog/downloads)](https://packagist.org/packages/pastuhov/yii2-yml-catalog)

YML (Yandex Market Language) generator.

## Install

Via Composer

``` bash
$ composer require pastuhov/yii2-yml-catalog
```

## Features

* 

## Usage

Configure the [[yii\base\Application::controllerMap|controller map]] in the application configuration. For example:
```php
[
    'controllerMap' => [
        ...
        // declares "yml" controller using a configuration array
        'yml' => [
            'class' => 'pastuhov\ymlcatalog\controllers\YmlCatalogController',
            'shopClass' => 'frontend\models\Shop',
            'categoryClass' => 'frontend\models\Category',
            'offerClass' => [
                'frontend\models\Item'
            ],
            'fileName' => 'yml.xml',
            'enableGzip' => true,
            'publicDir' => '@frontend/web'
        ],
    ],
]
```
Then you may type:
```bash
$ yii yml/generate
```

## Testing

```bash
$ composer test
```
or
```bash
$ phpunit
```

## Security

If you discover any security related issues, please email kirill@pastukhov.su instead of using the issue tracker.

## Credits

- [Kirill Pastukhov](https://github.com/pastuhov)
- [All Contributors](../../contributors)

## License

GNU General Public License, version 2. Please see [License File](LICENSE) for more information.
