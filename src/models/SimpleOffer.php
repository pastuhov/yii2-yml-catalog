<?php
namespace pastuhov\ymlcatalog\models;

class SimpleOffer extends BaseModel
{
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
    public $market_Category;
    public $picture;
    public $store;
    public $pickup;
    public $delivery;
    public $local_Delivery_Cost;
    public $name;
    public $vendor;
    public $vendorCode;
    public $description;
    public $sales_Notes;
    public $manufacturer_Warranty;
    public $country_Of_Origin;
    public $adult;
    public $age;
    public $barcode;
    public $cpa;
    public $param;

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
            'market_Category',
            'picture',
            'store',
            'pickup',
            'delivery',
            'local_Delivery_Cost',
            'name',
            'vendor',
            'vendorCode',
            'description',
            'sales_Notes',
            'manufacturer_Warranty',
            'country_Of_Origin',
            'adult',
            'age',
            'barcode',
            'cpa',
            'param',
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
                ['name'],
                'string',
                'max' => 255,
            ],
            [
                ['delivery'],
                'string',
                'max' => 4,
            ],
            [
                ['id', 'categoryId', 'bid', 'cbid'],
                'integer',
            ],
            [
                ['url', 'picture'],
                'url',
            ],
            [
                ['price', 'oldprice'],
                'double',
            ],
            [
                [
                    'currencyId',
                ],
                'in',
                'range' => [
                    'RUR',
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
                'max' => 175,
            ],
        ];
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

        return $string;
    }
}
