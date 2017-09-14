<?php
namespace pastuhov\ymlcatalog\Test;

use pastuhov\FileStream\BaseFileStream;
use pastuhov\ymlcatalog\actions\GenerateAction;
use pastuhov\ymlcatalog\Test\controllers\GenerateController;
use pastuhov\ymlcatalog\Test\models\CustomOffer;
use pastuhov\ymlcatalog\Test\models\SimpleOffer;
use pastuhov\ymlcatalog\YmlCatalog;
use Yii;
use yii\console\Controller;
use yii\db\Connection;
use yii\data\ActiveDataProvider;

class YmlCatalogTest extends DatabaseTestCase
{
    /**
     * Controller with stand alone action test
     *
     * @throws \yii\console\Exception
     */
    public function testController()
    {
        $controller = new GenerateController('yml', Yii::$app);

        $response = $controller->runAction('generate');

        $this->assertEquals(Controller::EXIT_CODE_NORMAL, $response);
        $this->assertFileExists(__DIR__ . '/runtime/public/yml-test.xml.gz');
    }

    /**
     * Проверка генерации XML с пользовательскими категориями.
     *
     * @throws \yii\console\Exception
     */
    public function testGenerateYmlWithCustomCategory()
    {
        $action = new GenerateAction('generate', $this, [
            'enableGzip' => true,
            'keepBoth' => true,
            'fileName' => 'custom-yml-test.xml',
            'publicPath' => '@runtime/public',
            'runtimePath' => '@runtime',
            'shopClass' => 'pastuhov\ymlcatalog\Test\models\Shop',
            'currencyClass' => 'pastuhov\ymlcatalog\Test\models\Currency',
            'categoryClass' => 'pastuhov\ymlcatalog\Test\models\CustomCategory',
            'deliveryOptionClass' => 'pastuhov\ymlcatalog\Test\models\DeliveryOption',
            'customCategoryClass' => 'pastuhov\ymlcatalog\Test\models\SatomCategoryClass',
            'offerClasses' => [
                [
                    'class' => 'pastuhov\ymlcatalog\Test\models\SimpleOffer',
                    'findParams' => [
                        'excluded' => [
                            13
                        ]
                    ]
                ]
            ],
            'onValidationError' => function () {

            }
        ]);
        $response = $action->run();

        $this->assertEquals(Controller::EXIT_CODE_NORMAL, $response);
        $fileName = __DIR__ . '/runtime/public/custom-yml-test.xml';
        $this->assertFileExists($fileName);

        $fileContent = file_get_contents($fileName);
        // Проверка на измененные тэги категорий
        $this->assertContains(
'<category id="1" portalid="portal-test">Оргтехника</category>
<category id="2" portalid="portal-test">Фототехника</category>
<category id="3" portalid="portal-test">Книги</category>
<category id="4" portalid="portal-test">Музыка и видеофильмы</category>
<category id="5" portalid="portal-test">Путешествия</category>', $fileContent);
    }

    /**
     * Тестирование генерации yml файла и сравнение с эталонным файлом
     */
    public function testYmlCatalogGenerate()
    {
        $handle = new BaseFileStream(__DIR__ . '/runtime/yml-catalog.xml');

        $generator = new YmlCatalog(
            $handle,
            'pastuhov\ymlcatalog\Test\models\Shop',
            'pastuhov\ymlcatalog\Test\models\Currency',
            'pastuhov\ymlcatalog\Test\models\Category',
            null,
            [
                [
                    'class' => 'pastuhov\ymlcatalog\Test\models\SimpleOffer',
                    'findParams' => [
                        'excluded' => [
                            13
                        ]
                    ]
                ]
            ],
            '2015-01-01 14:00',
            function () {

            },
            null,
            'pastuhov\ymlcatalog\Test\models\DeliveryOption'
        );
        $generator->generate();

        $this->assertXmlFileEqualsXmlFile(__DIR__ . '/data/yml-catalog.xml', __DIR__ . '/runtime/yml-catalog.xml');
    }

    /**
     * Custom offer model test
     */
    public function testYmlCatalogWithCustomModel()
    {
        $this->setExpectedException('yii\base\Exception', 'custom offer model exception');
        $handle = new BaseFileStream(__DIR__ . '/runtime/yml-catalog.xml');

        $generator = new YmlCatalog(
            $handle,
            'pastuhov\ymlcatalog\Test\models\Shop',
            'pastuhov\ymlcatalog\Test\models\Currency',
            'pastuhov\ymlcatalog\Test\models\Category',
            'pastuhov\ymlcatalog\Test\models\LocalDeliveryCost',
            ['pastuhov\ymlcatalog\Test\models\CustomItem'],
            '2015-01-01 14:00',
            function () {

            },
            CustomOffer::className()
        );
        $generator->generate();
    }
    
    /**
     * Тестирование генерации yml файла с использованием ActiveDataProvider и сравнение с эталонным файлом
     */
    public function testYmlCatalogGenerateActiveDataProvider()
    {
        $handle = new BaseFileStream(__DIR__ . '/runtime/yml-catalog.xml');

        $generator = new YmlCatalog(
            $handle,
            'pastuhov\ymlcatalog\Test\models\Shop',
            'pastuhov\ymlcatalog\Test\models\Currency',
            'pastuhov\ymlcatalog\Test\models\Category',
            null,
            [
                [
                    'class' => 'pastuhov\ymlcatalog\Test\models\SimpleOffer',
                    'dataProvider' => new ActiveDataProvider([
                        'query' => SimpleOffer::findYml()->andWhere(['not in', 'id', [13]]),
                        'pagination' => [
                            'pageSize' => 100,
                         ],
                    ]),
                ]
            ],
            '2015-01-01 14:00',
            function () {

            },
            null,
            'pastuhov\ymlcatalog\Test\models\DeliveryOption'
        );
        $generator->generate();

        $this->assertXmlFileEqualsXmlFile(__DIR__ . '/data/yml-catalog.xml', __DIR__ . '/runtime/yml-catalog.xml');

        // Тестирование генерации yml файла с использованием ActiveDataProvider без пагитнации
        $handle = new BaseFileStream(__DIR__ . '/runtime/yml-catalog.xml');

        $generator = new YmlCatalog(
            $handle,
            'pastuhov\ymlcatalog\Test\models\Shop',
            'pastuhov\ymlcatalog\Test\models\Currency',
            'pastuhov\ymlcatalog\Test\models\Category',
            null,
            [
                [
                    'class' => 'pastuhov\ymlcatalog\Test\models\SimpleOffer',
                    'dataProvider' => new ActiveDataProvider([
                        'query' => SimpleOffer::findYml()->andWhere(['not in', 'id', [13]]),
                        'pagination' => false
                    ]),
                ]
            ],
            '2015-01-01 14:00',
            function () {

            },
            null,
            'pastuhov\ymlcatalog\Test\models\DeliveryOption'
        );
        $generator->generate();

        $this->assertXmlFileEqualsXmlFile(__DIR__ . '/data/yml-catalog.xml', __DIR__ . '/runtime/yml-catalog.xml');
    }
    
    /**
     * Тестирование генерации yml файла с использованием ActiveQuery и сравнение с эталонным файлом
     */
    public function testYmlCatalogGenerateActiveQuery()
    {
        $handle = new BaseFileStream(__DIR__ . '/runtime/yml-catalog.xml');

        $generator = new YmlCatalog(
            $handle,
            'pastuhov\ymlcatalog\Test\models\Shop',
            'pastuhov\ymlcatalog\Test\models\Currency',
            'pastuhov\ymlcatalog\Test\models\Category',
            null,
            [
                [
                    'class' => 'pastuhov\ymlcatalog\Test\models\SimpleOffer',
                    'query' => SimpleOffer::findYml()->andWhere(['not in', 'id', [13]]),
                ]
            ],
            '2015-01-01 14:00',
            function () {

            },
            null,
            'pastuhov\ymlcatalog\Test\models\DeliveryOption'
        );
        $generator->generate();

        $this->assertXmlFileEqualsXmlFile(__DIR__ . '/data/yml-catalog.xml', __DIR__ . '/runtime/yml-catalog.xml');
    }

    /**
     * @inheritdoc
     */
    public static function setUpBeforeClass()
    {
        try {
            Yii::$app->set('db', [
                'class' => Connection::className(),
                'dsn' => 'sqlite::memory:',
            ]);
            Yii::$app->getDb()->open();
            $lines = explode(';', file_get_contents(__DIR__ . '/migrations/sqlite.sql'));
            foreach ($lines as $line) {
                if (trim($line) !== '') {
                    Yii::$app->getDb()->pdo->exec($line);
                }
            }
        } catch (\Exception $e) {
            Yii::$app->clear('db');
        }
    }

    /**
     * Тест для пользовательской категории.
     */
    public function testCustomCategory()
    {
        $handle = new BaseFileStream(__DIR__ . '/runtime/yml-catalog.xml');

        $generator = new YmlCatalog(
            $handle,
            'pastuhov\ymlcatalog\Test\models\Shop',
            'pastuhov\ymlcatalog\Test\models\Currency',
            'pastuhov\ymlcatalog\Test\models\CustomCategory',
            null,
            [
                [
                    'class' => 'pastuhov\ymlcatalog\Test\models\SimpleOffer',
                    'findParams' => [
                        'excluded' => [
                            13
                        ]
                    ]
                ]
            ],
            '2015-01-01 14:00',
            function () {

            },
            null,
            'pastuhov\ymlcatalog\Test\models\DeliveryOption',
            'pastuhov\ymlcatalog\Test\models\SatomCategoryClass'
        );
        $generator->generate();

        $this->assertXmlFileEqualsXmlFile(__DIR__ . '/data/yml-catalog-custom-category.xml', __DIR__ . '/runtime/yml-catalog.xml');
    }
}
