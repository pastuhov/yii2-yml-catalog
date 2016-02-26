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

* lightweight
* based on https://yandex.ru/support/partnermarket/yml/about-yml.xml

## Usage

Create console controller. For example:
```php
namespace console\controllers;

use pastuhov\ymlcatalog\actions\GenerateAction;
use yii\console\Controller;

/**
 * Class GenerateController
 */
class YmlController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'generate' => [
                'class' => GenerateAction::className(),
                'enableGzip' => true, # gzip yml after generation
                'fileName' => 'yml-test.xml', # target file name
                'publicPath' => '@runtime/public', # pulic directory
                'runtimePath' => '@runtime', # temp directory
                'keepBoth' => true # publish yml and .gz
                'shopClass' => 'pastuhov\ymlcatalog\Test\models\Shop',
                'currencyClass' => 'pastuhov\ymlcatalog\Test\models\Currency',
                'categoryClass' => 'pastuhov\ymlcatalog\Test\models\Category',
                'localDeliveryCostClass' => 'pastuhov\ymlcatalog\Test\models\LocalDeliveryCost',
                'offerClasses' => [
                    'pastuhov\ymlcatalog\Test\models\SimpleOffer'
                ],
            ],
        ];
    }
}
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
