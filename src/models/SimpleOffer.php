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

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param array $pictures
     */
    public function setPictures(array $pictures)
    {
        $this->pictures = $pictures;
    }

    /**
     * @param array $options
     *
     * @throws Exception
     */
    public function setDeliveryOptions(array $options)
    {
        if(count($options) > 5) {
            throw new InvalidParamException('Maximum count of delivery options array is 5');
        }
        $this->deliveryOptions = $options;
    }

    /**
     * @inheritdoc
     */
    protected function getYmlBody()
    {
        $string = '';

        foreach ($this->getYmlAttributes() as $attribute) {
            $string .= $this->getYmlAttribute($attribute);
        }

        foreach ($this->params as $name => $value) {
            $string .= $this->getYmlParamTag($name, $value);
        }

        foreach ($this->pictures as $picture) {
            $string .= $this->getYmlPictureTag($picture);
        }

        $this->appendDeliveryOptions($string);

        return $string;
    }

    /**
     * Добавляет теги ддля опций доставки
     *
     * @param $string
     *
     * @throws Exception
     */
    protected function appendDeliveryOptions(&$string) {
        if(count($this->deliveryOptions) < 1) {
            return;
        }
        $string .= '<delivery-options>' . PHP_EOL;
        $deliveryOptionBase = new DeliveryOption();

        foreach($this->deliveryOptions as $deliveryOption) {
            $deliveryOptionBase->loadModel($deliveryOption);
            $string .= $deliveryOptionBase->getYml();
        }
        $string .= '</delivery-options>' . PHP_EOL;
    }


    /**
     * @param string $attribute
     * @param string $value
     * @return string
     */
    protected function getYmlParamTag($attribute, $value)
    {
        if ($value === null) {
            return '';
        }

        $string = '<param name="' . $attribute . '">' . $value . '</param>' . PHP_EOL;

        return $string;
    }

    /**
     * @param string $value
     * @return string
     */
    protected function getYmlPictureTag($value)
    {
        if ($value === null) {
            return '';
        }

        $string = '<picture>' . $value . '</picture>' . PHP_EOL;

        return $string;
    }
}
