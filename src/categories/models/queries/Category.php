<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 5/18/17
 * Time: 3:00 PM
 */

namespace pastuhov\ymlcatalog\categories\models\queries;


use yii\db\ActiveQuery;

class Category extends ActiveQuery
{
    public function byExtCharId($id) {
        return $this->andWhere([
            'ext_char_id' => $id,
        ]);
    }
}