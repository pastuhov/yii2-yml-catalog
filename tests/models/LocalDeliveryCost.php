<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\LocalDeliveryCostInterface;

/**
 * @inheritdoc
 */
class LocalDeliveryCost implements LocalDeliveryCostInterface
{
    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return 300;
    }
}
