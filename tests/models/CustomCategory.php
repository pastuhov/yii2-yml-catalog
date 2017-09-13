<?php
namespace pastuhov\ymlcatalog\Test\models;

/**
 * @inheritdoc
 *
 * @property string name
 */
class CustomCategory extends Category
{
    /**
     * @var string Класс для подмены Category
     */
    public $customCategoryClass = SatomCategoryClass::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * Тестовый пользовательский атрибут.
     *
     * @return string
     */
    public function getPortalid()
    {
        return 'portal-test';
    }
}