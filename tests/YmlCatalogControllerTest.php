<?php
namespace pastuhov\ymlcatalog\Test;

use Yii;
use yii\db\Connection;
use pastuhov\ymlcatalog\controllers\YmlCatalogController;

class FileStreamTest extends DatabaseTestCase
{
    /**
     * @throws \yii\console\Exception
     */
    public function testInit()
    {
        $controller = new YmlCatalogController('yml', \Yii::$app);

        $controller->enableGzip = false;
        $controller->fileName = 'yml-test.xml';
        $controller->publicPath = '@tests';
        $controller->runtimePath = '@runtime';

        $response = $controller->runAction('generate', ['interactive' => 0]);

        $this->assertEquals('OK', $response);
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
