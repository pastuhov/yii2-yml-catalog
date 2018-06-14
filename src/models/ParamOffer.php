<?php

namespace pastuhov\ymlcatalog\models;

/**
 * Class ParamOffer
 * Модель все важные характеристики товара — цвет, размер, объем, материал, вес, возраст, пол, и т. д.
 *
 * @package pastuhov\ymlcatalog\models
 */
class ParamOffer extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static $tag = 'param';

    /**
     * @inheritdoc
     */
    public static $tagProperties = [
        'name',
        'unit',
    ];

    /** @var string Название параметра. */
    public $name;

    /** @var string Единицы измерения. */
    public $unit;

    /** @var string Значение параметра. */
    public $value;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['name', 'value'],
                'required',
            ],
            [
                ['name', 'value', 'unit'],
                'string',
            ],
        ];
    }

    protected function getYmlBody()
    {
        return $this->value;
    }
}
