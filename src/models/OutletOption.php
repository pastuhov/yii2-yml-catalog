<?php
namespace pastuhov\ymlcatalog\models;

/**
 * Class DeliveryOption
 *
 * Модель опции условий доставки - тега option в секции delivery-option
 * @package pastuhov\ymlcatalog\models
 */
class OutletOption extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static $tag = 'outlet';

    /**
     * @var int Идентификатор точки продаж, заданный в личном кабинете.
     */
    public $id;

    /**
     * @var int Количество товара, доступное для бронирования в точке продаж. Число должно быть равно либо больше 0
     */
    public $instock;

    /**
     * @var string Возможность бронирования в точке продаж
     */
    public $booking;

    /**
     * @inheritdoc
     */
    public static function getTagProperties()
    {
        return [
            'id',
            'instock',
            'booking',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id'],
                'required',
            ],
            [
                ['id'],
                'number',
                'integerOnly' => true,
                'min' => 0,
                'max' => SimpleOffer::NUMBER_LIMIT,
            ],
            [
                ['instock'],
                'number',
                'integerOnly' => true,
                'min' => 0,
                'max' => SimpleOffer::NUMBER_LIMIT,
            ],
            [
                ['booking'],
                'in',
                'range' => [
                    'true',
                    'false'
                ]
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
