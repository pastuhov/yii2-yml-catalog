<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 5/17/17
 * Time: 5:49 PM
 */

namespace pastuhov\ymlcatalog\Test;


use pastuhov\ymlcatalog\ModelsFactory;
use pastuhov\ymlcatalog\Test\models\Currency;
use yii\base\Exception;

class ModelsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate() {
        $factory = new ModelsFactory([
            'modelClass' => Currency::class,
        ]);
        $this->assertInstanceOf(\pastuhov\ymlcatalog\models\Currency::class, $factory->create());
    }

    public function testWrongInterfaceException() {
        $factory = new ModelsFactory([
            'modelClass' => get_class($this),
        ]);

        $this->setExpectedException(Exception::class, 'Instance ' . get_class($this) . ' is not haved YML model interface');
        $factory->create();
    }
}