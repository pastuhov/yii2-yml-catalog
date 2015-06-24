<?php
namespace pastuhov\ymlcatalog\models;

class Category extends BaseModel
{
    public static $tag = 'category';
    public static $startTagProperties = [
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
