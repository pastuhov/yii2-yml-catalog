<?php
namespace pastuhov\ymlcatalog\models;

class LocalDeliveryCost extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static $tag = 'local_delivery_cost';

    public $value;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['value'],
                'integer',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getYmlBody()
    {
        return $this->value;
    }
}
