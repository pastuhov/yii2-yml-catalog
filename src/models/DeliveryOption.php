<?php
namespace pastuhov\ymlcatalog\models;

/**
 * Class DeliveryOption
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
    ];

    public $cost;
    public $days;

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
                ['cost'],
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
}
