<?php

namespace pastuhov\ymlcatalog\Test\models;

use yii\base\Exception;

class CustomOffer extends \pastuhov\ymlcatalog\models\CustomOffer
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        throw new Exception('custom offer model exception');
    }
}
