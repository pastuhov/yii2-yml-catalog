<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 4/28/17
 * Time: 5:02 PM
 */

namespace pastuhov\ymlcatalog\models;


abstract class Offer extends BaseModel
{
    const NUMBER_LIMIT = 99999999999999999999;
    /**
     * @inheritdoc
     */
    public static $tag = 'offer';

    public $id;
    public $cbid;
    public $bid;
    public $fee;

    public $url;
    public $price;
    public $oldprice;
    public $currencyId;
    public $categoryId;
    public $pictures = [];
    public $delivery;

    /**
     * Опции доставки
     *
     * @var array
     */
    public $deliveryOptions = [];

    public $pickup;
    public $available;
    public $store;

    public $outlets = [];

    public $description;
    public $sales_notes;

    public $minQuantity;
    public $stepQuantity;

    public $manufacturer_warranty;
    public $country_of_origin;
    public $adult;
    public $age;
    public $barcode;
    public $cpa;
    public $params = [];

    public $expiry;
    public $weight;


    /**
     * Элемент предназначен для указания габаритов товара (длина, ширина, высота) в упаковке. Размеры указываются в сантиметрах.
     *
     * @var array
     */
    public $dimensionsValues = [];

    public $downloadable;
    public $group_id;

    /**
     * Элемент предназначен для передачи рекомендованных товаров.
     *
     * @var array
     */
    public $recValues = [];

    /**
     * @inheritdoc
     */
    public static function getTagProperties() {
        return [
            'id',
            'cbid',
            'bid',
            'available',
            'fee',
            'group_id'
        ];
    }

    public function getRec() {
        if (!$this->recValues) {
            return null;
        }

        return implode(',', $this->recValues);
    }

    public function getDimensions() {
        if (!$this->dimensionsValues) {
            return null;
        }

        return implode('/', $this->dimensionsValues);
    }

    /**
     * @inheritdoc
     */
    public function getYmlAttributes()
    {
        return [
            'fee',
            'url',
            'price',
            'oldprice',
            'currencyId',
            'categoryId',
            'store',
            'pickup',
            'delivery',
            'description',
            'sales_notes',
            'min-quantity' => 'minQuantity',
            'step-quantity' => 'stepQuantity',
            'expiry',
            'manufacturer_warranty',
            'country_of_origin',
            'adult',
            'age',
            'barcode',
            'cpa',
            'weight',
            'dimensions',
            'downloadable',
            'group_id',
            'rec',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id', 'url', 'price', 'currencyId', 'categoryId'],
                'required',
            ],
            [
                ['id', 'cbid', 'bid', 'fee', 'minQuantity'],
                'integer',
                'min' => 0,
                'max' => self::NUMBER_LIMIT,
            ],
            [
                ['url'],
                'url',
            ],
            [
                ['url'],
                'string',
                'max' => 512,
            ],
            [
                ['price', 'oldprice'],
                'double',
            ],
            [
                'oldprice',
                function ($attribute, $value) {
                    if ($this->$attribute <= $this->price) {
                        $this->addError($attribute, 'Old price must be greater than price');
                    }
                }
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
                ['categoryId'],
                'integer',
                'min' => 0,
                'max' => 999999999999999999,
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
                'rule' => ['string', 'max' => 512],
            ],
            [
                ['pictures'],
                'each',
                'rule' => ['url']
            ],
            [
                ['delivery', 'pickup', 'available', 'store', 'manufacturer_warranty', 'downloadable', 'adult',],
                'in',
                'range' => [
                    'true',
                    'false'
                ]
            ],
            [
                ['deliveryOptions'],
                function ($attribute, $params) {
                    $value = $this->$attribute;
                    if (empty($value)) {
                        if ($this->delivery === 'true') {
                            $this->addError($attribute, 'Delivery options is required while delivery equal \'true\'');
                        }
                    } else {
                        if (count($value) > 5) {
                            $this->addError($attribute, 'Delivery options count greater whan 5');
                        }
                    }
                },
                'skipOnEmpty' => false,
            ],
            [
                ['outlets'],
                'safe',
            ],
            [
                ['description'],
                'string',
                'max' => 3000,
            ],
            [
                ['sales_notes'],
                'string',
                'max' => 50,
            ],
            [
                ['stepQuantity'],
                'integer',
                'min' => 1,
                'max' => self::NUMBER_LIMIT,
            ],
            [
                ['barcode'],
                'string',
                'max' => 250,
            ],
//            [
//                ['age'],
//                'in',
//                'range' => [
//                    0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12
//                ],
//            ],
            [
                ['cpa'],
                'integer',
                'min' => 0,
                'max' => 1,
            ],
            [
                ['params'],
                'each',
                'rule' => ['string']
            ],
            [
                ['expiry'],
                'date',
                'format' => 'yyyy-MM-ddTHH:mm',
            ],
            [
                ['weight'],
                'number',
                'numberPattern' => '/^\[0-9]*\.?[0-9]+\s*$/'
            ],
            [
                'dimensionsValues',
                'each',
                'rule' => ['number', 'numberPattern' => '/^[0-9]*\.?[0-9]+\s*$/'],
            ],
            [
                'dimensionsValues',
                function ($attribute, $params) {
                    $count = count($this->$attribute);
                    if ($count && $count != 3) {
                        $this->addError($attribute, 'dimensions must have 3 values');
                    }
                }
            ],
            [
                'recValues',
                'each',
                'rule' => ['number', 'min' => 0, 'max' => self::NUMBER_LIMIT],
            ],
            [
                'recValues',
                function ($attribute, $params) {
                    $count = count($this->$attribute);
                    if ($count > 30) {
                        $this->addError($attribute, 'maximum 30 recommended offers');
                    }
                }
            ],
            [
                ['group_id'],
                'integer',
                'min' => 0,
                'max' => 999999999,
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

        $this->appendOutletOptions($string);

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
            $deliveryOptionBase->loadAndValidate($deliveryOption);
            $string .= $deliveryOptionBase->getYml();
        }
        $string .= '</delivery-options>' . PHP_EOL;
    }

    /**
     * Добавляет теги ддля опций доставки
     *
     * @param $string
     *
     * @throws Exception
     */
    protected function appendOutletOptions(&$string) {
        if(count($this->outlets) < 1) {
            return;
        }

        $string .= '<outlet>' . PHP_EOL;
        $outletOptionBase = new OutletOption();

        foreach($this->outlets as $outletOption) {
            $outletOptionBase->loadAndValidate($outletOption);
            $string .= $outletOptionBase->getYml();
        }
        $string .= '</outlet>' . PHP_EOL;
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