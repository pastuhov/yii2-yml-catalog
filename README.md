# Компонент выгрузки каталога товаров в Яндекс.Маркет (YML)

[![Build Status](https://travis-ci.org/pastuhov/yii2-yml-catalog.svg)](https://travis-ci.org/pastuhov/yii2-yml-catalog)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pastuhov/yii2-yml-catalog/?branch=master)
[![Total Downloads](https://poser.pugx.org/pastuhov/yii2-yml-catalog/downloads)](https://packagist.org/packages/pastuhov/yii2-yml-catalog)

## Установка

Via Composer

``` bash
$ composer require pastuhov/yii2-yml-catalog
```

## Features

* легкий
* базируется на официальной документации https://yandex.ru/support/partnermarket/yml/about-yml.xml

## Использование

1. Реализуем интерфейсы (примеры реализации всех классов смотри в директории `tests`)

2. Создаем консольный контроллер:
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
                'enableGzip' => true, # запаковать gzip-ом yml после генерации
                'fileName' => 'yml-test.xml', # желаемое название файла
                'publicPath' => '@runtime/public', # публичная директория (обычно корень веб сервера)
                'runtimePath' => '@runtime', # временная директория
                'keepBoth' => true # опубликовать yml и .gz
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
3. Запускаем из консоли:
```bash
$ yii yml/generate
```

## Дополнительно

Дополнительно с именем класса, реализации интерфейса, можно передавать следующие параметры:
1. Объект класса ActiveQuery, или его наследника.
```php
'categoryClass' => [
    'class' => 'pastuhov\ymlcatalog\Test\models\Category',
    'query' => \pastuhov\ymlcatalog\Test\models\Category\Category::find(),
]
```
В данном случае, выборка данных будет производиться с помощью передаваемого ActiveQuery или его наследника;
Позволяет использовать уже созданный объект, для выборки данных.

2. Объект класса ActiveDataProvider, или его наследника.
```php
'categoryClass' => [
    'class' => 'class' => 'pastuhov\ymlcatalog\Test\models\Category',
    'dataProvider' => new ActiveDataProvider([
        'query' => Category::find(),
        'pagination' => [
            'pageSize' => 1000,
        ]
    ]),
]
```
В данном случае, выборка данных будет производиться с помощью передаваемого ActiveDataProvider или его наследника;

Позволяет делать выборку данных с использованием постраничной пагинации.

Так-же может быть передан true, в качестве параметра, для автоматического создания объекта класса ActiveDataProvider 
со значением количества строк в странице равной 1000.
```php
'categoryClass' => [
    'class' => 'class' => 'pastuhov\ymlcatalog\Test\models\Category',
    'dataProvider' => new ActiveDataProvider([
        'query' => Category::find(),
        'pagination' => true,
    ]
]
```
На больших объемах данных, выборка, с использованием ActiveQuery->batch(), расходует оперативную память, 
гораздо большую, чем значение установленное в конфигурацилнных файлах. (Скорее всего особенности работы библиотеки PDO).
**Внимание:** Использование ActiveDataProvider увеличивает время генерации выгрузки.

## Тестирование

```bash
$ composer test
```
или
```bash
$ phpunit
```
Проверить качество сгенерируемого файла можно следующими способами:
1. Официальным валидатором https://old.webmaster.yandex.ru/xsdtest.xml 
2. При помощи `xmllint` (пример: xmllint --valid --noout yml-test.xml)
3. IDE PhpStorm также может помочь

## Security

If you discover any security related issues, please email kirill@pastukhov.su instead of using the issue tracker.

## Credits

- [Kirill Pastukhov](https://github.com/pastuhov)
- [All Contributors](../../contributors)

## License

GNU General Public License, version 2. Please see [License File](LICENSE) for more information.
