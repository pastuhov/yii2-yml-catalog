<?php
namespace pastuhov\ymlcatalog\models;

/**
 * Class Category
 * @package pastuhov\ymlcatalog\models
 */
class Category extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static $tag = 'category';

    public $name;
    public $parentId;
    public $id;

    /**
     * @inheritdoc
     */
    public static function getTagProperties()
    {
        return [
            'id',
            'parentId',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id', 'name'],
                'required',
            ],
            [
                ['name'],
                'string',
                'max' => 255,
            ],
            [
                ['id', 'parentId'],
                'integer',
                'min' => 1,
                'max' => SimpleOffer::NUMBER_LIMIT,
            ],
        ];
    }
}
