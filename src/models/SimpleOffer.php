<?php

namespace pastuhov\ymlcatalog\models;

use pastuhov\ymlcatalog\ParamOfferInterface;
use yii\base\Exception;
use yii\base\InvalidParamException;

class SimpleOffer extends BaseModel
{
    /**
     * @var int Максимальная длина тэга sales_notes
     */
    public static $maxLengthSalesNotes = 50;
    /**
     * @var int Максимальная длина тэга vendor
     */
    public static $maxLengthVendor = 120;
    /**
     * @var int Максимальная длина тэга name
     */
    public static $maxLengthName = 120;
    /**
     * @inheritdoc
     */
    public static $tag = 'offer';
    /**
     * @inheritdoc
     */
    public static $tagProperties = [
        'id',
        'bid',
        'cbid',
        'available'
    ];

    public $id;
    public $bid;
    public $cbid;
    public $available;

    public $url;
    public $price;
    public $oldprice;
    public $currencyId;
    public $categoryId;
    public $market_category;
    public $store;
    public $pickup;
    public $delivery;
    public $local_delivery_cost;
    public $name;
    public $vendor;
    public $vendorCode;
    public $description;
    public $sales_notes;
    public $manufacturer_warranty;
    public $country_of_origin;
    public $adult;
    public $age;
    public $barcode;
    public $cpa;
    public $params = [];
    public $pictures = [];
    /**
     * Опции доставки
     *
     * @var array
     */
    public $deliveryOptions = [];

    /**
     * @inheritdoc
     */
    public function getYmlAttributes()
    {
        return [
            'url',
            'price',
            'oldprice',
            'currencyId',
            'categoryId',
            'market_category',
            'store',
            'pickup',
            'delivery',
            'local_delivery_cost',
            'name',
            'vendor',
            'vendorCode',
            'description',
            'sales_notes',
            'manufacturer_warranty',
            'country_of_origin',
            'adult',
            'age',
            'barcode',
            'cpa',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id', 'price', 'currencyId', 'categoryId', 'name', 'available'],
                'required',
            ],
            [
                ['sales_notes'],
                'string',
                'max' => static::$maxLengthSalesNotes,
            ],
            [
                ['vendor'],
                'string',
                'max' => static::$maxLengthVendor,
            ],
            [
                ['name'],
                'string',
                'max' => static::$maxLengthName,
            ],
            [
                ['delivery', 'pickup', 'store', 'manufacturer_Warranty', 'adult'],
                'boolean',
                'trueValue' => 'true',
                'falseValue' => 'false',
                'strict' => true,
            ],
            [
                ['cpa'],
                'boolean'
            ],
            [
                ['id', 'categoryId', 'bid', 'cbid', 'age'],
                'integer',
            ],
            [
                ['name', 'market_Category', 'vendorCode', 'country_Of_Origin', 'barcode'],
                'string',
            ],
            [
                ['url'],
                'url',
            ],
            [
                ['price', 'oldprice', 'local_Delivery_Cost'],
                'double',
            ],
            [
                [
                    'currencyId',
                ],
                'in',
                'range' => [
                    'RUR',
                    'RUB',
                    'UAH',
                    'BYR',
                    'KZT',
                    'USD',
                    'EUR'
                ],
            ],
            [
                ['description'],
                'string',
            ],
            [
                ['pictures'],
                function ($attribute, $params) {
                    if (count($this->pictures) > 10) {
                        $this->addError('pictures', 'maximum 10 pictures');
                    }
                }
            ],
            [
                ['pictures'],
                'each',
                'rule' => ['url']
            ],
        ];
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

        foreach ($this->pictures as $picture) {
            $string .= $this->getYmlPictureTag($picture);
        }

        $this->appendParamTags($string);
        $this->appendDeliveryOptions($string);

        return $string;
    }

    /**
     * Добавляет теги для опций доставки
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
     *
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
     * Добавляет теги для описания характеристик и параметров товара.
     *
     * @param string $string
     * @throws Exception
     */
    protected function appendParamTags(&$string)
    {
        if(count($this->params) < 1) {
            return;
        }

        $paramOfferBase = new ParamOffer();

        foreach($this->params as $name => $param) {
            if (!($param instanceof ParamOfferInterface)) {
                if (is_string($param)) {
                    $string .= $this->getYmlParamTag($name, $param);
                }
                continue;
            }
            $paramOfferBase->loadModel($param);
            $string .= $paramOfferBase->getYml();
        }
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
