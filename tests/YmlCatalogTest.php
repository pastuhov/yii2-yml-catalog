<?php
namespace pastuhov\ymlcatalog\Test;

use pastuhov\FileStream\BaseFileStream;
use pastuhov\ymlcatalog\Test\controllers\GenerateController;
use pastuhov\ymlcatalog\Test\models\CustomOffer;
use pastuhov\ymlcatalog\YmlCatalog;
use Yii;
use yii\console\Controller;
use yii\db\Connection;

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
            ['pastuhov\ymlcatalog\Test\models\CustomItem'],
            '2015-01-01 14:00',
            function () {

            }
        );
        $generator->generate();
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
}
