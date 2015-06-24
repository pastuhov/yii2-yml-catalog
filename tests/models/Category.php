<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\CategoryInterface;
use yii\db\ActiveRecord;

/**
 * @inheritdoc
 *
 * @property string name
 */
class Category extends ActiveRecord implements CategoryInterface
{

    /**
     * Название категории.
     *
     * @return string
     */
    public function getName()
    {
        $this->attributes['name'];
    }

    /**
     * Идентификатор категории товаров.
     *
     * Идентификатор категории должен быть уникальным положительным целым числом. Ни у одной категории параметр id не
     * может быть равен «0»
     *
     * @return int
     */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /**
     * Идентификатор более высокой по иерархии (родительской) категории товаров.
     *
     * Если элемент <parentId> не указан, то категория считается корневой.
     *
     * @return int|null
     */
    public function getParentId()
    {
        // TODO: Implement getParentId() method.
    }
}