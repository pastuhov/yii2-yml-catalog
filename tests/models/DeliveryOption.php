<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\DeliveryOptionInterface;

class DeliveryOption implements DeliveryOptionInterface 
{
    /**
     * Returns the fully qualified name of this class.
     * @return string the fully qualified name of this class.
     */
    public static function className()
    {
        return get_called_class();
    }

    public function getCost()
    {
        return 0;
    }

    public function getDays()
    {
        return '1-2';
    }

}
