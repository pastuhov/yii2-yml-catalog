<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 5/18/17
 * Time: 10:56 AM
 */

namespace pastuhov\ymlcatalog\Test\categories;


use pastuhov\ymlcatalog\categories\SourceToArrayConverter;

class SourceToArrayConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testRun() {
        $source = 'Все товары
Все товары/Авто/Автомобильные инструменты
';
        $converter = new SourceToArrayConverter([
            'source' => $source,
        ]);
        $this->assertEquals([
            md5('Все товары') => [
                'id' => md5('Все товары'),
                'name' => 'Все товары',
                'fullName' => 'Все товары',
                'line' => 0,
            ],
            md5('Все товары/Авто') => [
                'id' => md5('Все товары/Авто'),
                'name' => 'Авто',
                'fullName' => 'Все товары/Авто',
                'parent' => md5('Все товары'),
                'line' => 1,
            ],
            md5('Все товары/Авто/Автомобильные инструменты') => [
                'id' => md5('Все товары/Авто/Автомобильные инструменты'),
                'name' => 'Автомобильные инструменты',
                'fullName' => 'Все товары/Авто/Автомобильные инструменты',
                'parent' => md5('Все товары/Авто'),
                'line' => 1,
            ],
        ], $converter->convert());
    }
}