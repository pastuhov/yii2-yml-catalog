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
     * @inheritdoc
     */
    public function getName()
    {
        return $this->attributes['name'];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * @inheritdoc
     */
    public function getParentId()
    {
        return $this->attributes['parent_id'];
    }

    /**
     * @inheritdoc
     */
    public static function findYml()
    {
        $query = self::find();
        $query->orderBy('id');

        return $query;
    }
}