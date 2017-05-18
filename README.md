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
                'keepBoth' => true, # опубликовать yml и .gz
                'shopClass' => 'pastuhov\ymlcatalog\Test\models\Shop',
                'currencyClass' => 'pastuhov\ymlcatalog\Test\models\Currency',
                'categoryClass' => 'pastuhov\ymlcatalog\Test\models\Category',
                'offerClass' => [ # Можно указывать сразу несколько моделей
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

## Использование справочника категорий YML
Если многие категории сайта распознаются Яндексом не правильно, необходимо категории сайта сопоставить
с категориями маркета. Для того, чтобы вам помочь в этом нами создан справочник категорий Яндекса. Он имеется в двух форматах:
в виде ассоциативного массива или в виде таблицы в БД.
##### Справочник из массива PHP
Массив можно найти в файле src/categories/data/categories.php.
##### Справочник в БД
Чтобы залить категории Яндекса в свою БД необходимо применить миграции:
```bash
$ yii migrate/up --migrationPath=vendor/pastuhov/yii2-yml-catalog/src/categories/migrations
```
После этого необходимо залить в БД данные командой, добавив её в конфиг консольного приложения
```php
...
    'controllerMap' => [
        'ymlConvert' => pastuhov\ymlcatalog\categories\controllers\ConvertController::class,
    ]
...
```
и выполнить консольную команду
```bash
$ yii .ymlConvert/to-database
```
После этого модель pastuhov\ymlcatalog\categories\models\yml\Categories можно использовать для генерации категорий YML
и связывать её со своими категориями.

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


## Планы

* Поддержка price from="true"
* Поддержка age
* Поддержка нескольких barcode
* Поддержка в expiry формата вида P1Y2M10DT2H30M
* Действие для скачивания файла напрямую Яндексом

## Security

If you discover any security related issues, please email kirill@pastukhov.su instead of using the issue tracker.

## Credits

- [Kirill Pastukhov](https://github.com/pastuhov)
- [All Contributors](../../contributors)

## License

GNU General Public License, version 2. Please see [License File](LICENSE) for more information.
