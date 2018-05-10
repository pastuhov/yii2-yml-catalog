<?php
namespace pastuhov\ymlcatalog\models;

/**
 * Class DeliveryOption
 *
 * Модель опции условий доставки - тега option в секции delivery-option
 * @package pastuhov\ymlcatalog\models
 */
class DeliveryOption extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static $tag = 'option';

    /**
     * @inheritdoc
     */
    public static $tagProperties = [
        'cost',
        'days',
        'orderBefore' => 'order-before'
    ];

    /** @var int Стоимость доставки в рублях. */
    public $cost;

    /** @var string Срок доставки в рабочих днях. */
    public $days;

    /** @var int Время, до которого нужно сделать заказ, чтобы получить его в этот срок. */
    public $orderBefore;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['cost', 'days'],
                'required',
            ],
            [
                ['cost', 'orderBefore'],
                'integer',
            ],
            [
                ['days'],
                'string',
                'max' => 5,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getYmlBody()
    {
        return null;
    }

    /**
     * @return string
     */
    protected function getYmlStartTag()
    {
        return str_replace('>', ' />', parent::getYmlStartTag());
    }

    /**
     * @return string
     */
    protected function getYmlEndTag()
    {
        return '';
    }
}
