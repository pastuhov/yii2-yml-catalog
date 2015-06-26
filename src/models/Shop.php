<?php
namespace pastuhov\ymlcatalog\models;

class Shop extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static $tag = false;

    public $name;
    public $company;
    public $url;
    public $platform;
    public $version;
    public $agency;
    public $email;
    public $cpa;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['name', 'company', 'url'],
                'required',
            ],
            [
                ['name'],
                'string',
                'max' => 20,
            ],
            [
                ['company', 'url', 'platform', 'version', 'agency', 'email'],
                'string',
                'max' => 255,
            ],
            [
                ['email'],
                'email',
            ],
            [
                ['cpa'],
                'in',
                'range' => ['1', '2'],
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
