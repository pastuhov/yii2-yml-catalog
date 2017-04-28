<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 4/28/17
 * Time: 10:11 AM
 */

namespace pastuhov\ymlcatalog\models;


use yii\helpers\ArrayHelper;

class CustomOffer extends Offer
{
    public $model;
    public $vendor;
    public $vendorCode;
    public $typePrefix;
    public $type = 'vendor.model';
    /**
     * @inheritdoc
     */
    public static function getTagProperties() {
        return ArrayHelper::merge(parent::getTagProperties(), [
            'type'
        ]);
    }

    public function getYmlAttributes()
    {
        return ArrayHelper::merge(parent::getYmlAttributes(), [
            'model',
            'vendor',
            'vendorCode',
            'typePrefix',
        ]);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['type', 'model', 'vendor'], 'required'],
            [['model', 'vendor', 'vendorCode', 'typePrefix'], 'string', 'max' => 200],
        ]);
    }
}