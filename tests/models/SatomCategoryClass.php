<?php
namespace pastuhov\ymlcatalog\Test\models;

use yii\helpers\ArrayHelper;

/**
 * Пример пользовательского класса с собственным атрибутом.
 */
class SatomCategoryClass extends \pastuhov\ymlcatalog\models\Category
{
    /**
     * @inheritdoc
     */
    public static $tagProperties = [
        'id',
        'parentId',
        'portalid',
    ];

    /**
     * @var Ид категории, сопоставленный категории сайта.
     */
    public $portalid;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                ['portalid', 'string'],
            ]
        );
    }
}
