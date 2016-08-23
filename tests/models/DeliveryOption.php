<?php

namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\DeliveryOptionInterface;

/**
 * @inheritdoc
 */
class DeliveryOption implements DeliveryOptionInterface
{
    /**
     * @inheritdoc
     */
    public function getCost()
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function getDays()
    {
        return '1-2';
    }
}
