<?php
namespace pastuhov\ymlcatalog\models;

class LocalDeliveryCost extends BaseModel
{
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

    protected function getYmlBody()
    {
        return $this->value;
    }
}
