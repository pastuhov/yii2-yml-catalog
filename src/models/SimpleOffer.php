<?php

namespace pastuhov\ymlcatalog\models;

use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;

class SimpleOffer extends Offer
{
    public $name;
    public $model;
    public $vendor;
    public $vendorCode;
    public function getYmlAttributes()
    {
        return ArrayHelper::merge(parent::getYmlAttributes(), [
            'name',
            'model',
            'vendor',
            'vendorCode',
        ]);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name'], 'required'],
            [
                ['name', 'vendor', 'vendorCode', 'model'],
                'string',
                'max' => 120,
            ],
        ]);
    }
}
