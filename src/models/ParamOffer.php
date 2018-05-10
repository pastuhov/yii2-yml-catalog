<?php
namespace pastuhov\ymlcatalog\models;

/**
 * Class DeliveryOption
 *
 * Модель опции условий доставки - тега option в секции delivery-option
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
                ['cost'],
                'integer',
            ],
            [
                ['name', 'value', 'unit'],
                'string',
            ],
        ];
    }
}
