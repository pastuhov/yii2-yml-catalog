<?php
namespace pastuhov\ymlcatalog;

/**
 * Стоимость доставки для своего региона, для всех товаров.
 *
 * @package pastuhov\yml
 */
interface LocalDeliveryCostInterface
{
    /**
     * Значение.
     *
     * Для обозначения бесплатной доставки используйте значение 0.
     *
     * @return integer|0
     */
    public function getValue();
}
