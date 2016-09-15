<?php

namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\DeliveryOptionInterface;

/**
 * @inheritdoc
 */
class DeliveryOption implements DeliveryOptionInterface
{
    /**
     * Стоимость доставки
     *
     * @var int
     */
    public $cost = 0;

    /**
     * Срок доставки
     *
     * @var string
     */
    public $days = '1-2';

    /**
     * @inheritdoc
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @inheritdoc
     */
    public function getDays()
    {
        return $this->days;
    }
}
