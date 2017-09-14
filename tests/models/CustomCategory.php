<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\CustomCategoryInterface;

/**
 * @inheritdoc
 *
 * @property string name
 */
class CustomCategory extends Category implements CustomCategoryInterface
{
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
