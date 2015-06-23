<?php
namespace pastuhov\ymlcatalog\Test;

use pastuhov\ymlcatalog\controllers\YmlCatalogController;

class FileStreamTest extends \PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $controller = new YmlCatalogController('yml', \Yii::$app);
        //$controller->migrationPath = '@console/migrations';
        $response = $controller->runAction('generate', ['interactive' => 0]);
        $this->assertEquals('OK', $response);
    }
}