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
     * До скольки заказ
     *
     * @var int
     */
    public $orderBefore = null;

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

    /**
     * @inheritdoc
     */
    public function getOrderBefore()
    {
        return $this->orderBefore;
    }
}
