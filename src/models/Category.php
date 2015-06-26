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

    /**
     * @inheritdoc
     */
    public static $tagProperties = [
        'id',
        'parentId',
    ];

    public $name;
    public $parentId;
    public $id;

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
            ],
        ];
    }
}
