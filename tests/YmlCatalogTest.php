<?php
namespace pastuhov\ymlcatalog\Test;

use pastuhov\FileStream\BaseFileStream;
use pastuhov\ymlcatalog\Test\models\Shop;
use pastuhov\ymlcatalog\YmlCatalog;
use Yii;
use yii\console\Controller;
use yii\db\Connection;
use pastuhov\ymlcatalog\controllers\YmlCatalogController;

class YmlCatalogTest extends DatabaseTestCase
{
    /**
     * @throws \yii\console\Exception
     */
    public function testController()
    {
        $controller = new YmlCatalogController('yml', Yii::$app);

        $controller->enableGzip = true;
        $controller->fileName = 'yml-test.xml';
        $controller->publicPath = '@runtime/public';
        $controller->runtimePath = '@runtime';
        $controller->shopClass = 'pastuhov\ymlcatalog\Test\models\Shop';
        $controller->categoryClass = 'pastuhov\ymlcatalog\Test\models\Category';
        $controller->offerClass = 'pastuhov\ymlcatalog\Test\models\Offer';

        $response = $controller->runAction('generate');

        $this->assertEquals(Controller::EXIT_CODE_NORMAL, $response);
        $this->assertFileExists(__DIR__ . '/runtime/public/yml-test.xml.gz');
    }

    public function testYmlCatalogGenerate()
    {
        $handle = new BaseFileStream(__DIR__ . '/runtime/yml-catalog.xml');

        $generator = new YmlCatalog(
            $handle,
            new Shop(),
            'pastuhov\ymlcatalog\Test\models\Category',
            'pastuhov\ymlcatalog\Test\models\Offer',
            '2015-01-01 14:00'
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
}
