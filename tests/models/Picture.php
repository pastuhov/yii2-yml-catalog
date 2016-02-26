<?php
namespace pastuhov\ymlcatalog\Test\models;

use yii\db\ActiveRecord;

/**
 * @inheritdoc
 *
 * @property string url
 * @property int item_id
 */
class Picture extends ActiveRecord
{
    public function getUrl()
    {
        return $this->attributes['url'];
    }
}
