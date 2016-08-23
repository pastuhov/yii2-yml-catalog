<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\LocalDeliveryCostInterface;

/**
 * @inheritdoc
 * @deprecated
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
