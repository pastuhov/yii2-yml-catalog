<?php
namespace pastuhov\ymlcatalog\models;

class Currency extends BaseModel
{
    public static $tag = 'currency';
    public static $startTagProperties = [
        'id',
        'rate',
        'plus',
    ];

    public $id;
    public $rate;
    public $plus;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'rate',
                ],
                'required',
            ],
            [
                [
                    'rate',
                ],
                'string',
                'max' => 5,
            ],
            [
                [
                    'id',
                ],
                'string',
                'max' => 3,
            ],
            [
                [
                    'plus',
                ],
                'integer',
            ],
            [
                [
                    'id',
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
