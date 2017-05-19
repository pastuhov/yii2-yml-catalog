<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\CustomOfferInterface;

/**
 * @inheritdoc
 */
class CustomItem extends SimpleOffer implements CustomOfferInterface, BaseFindYmlInterface
{

    /**
     * Тип / категория товара (например, «мобильный телефон», «стиральная машина», «угловой диван»).
     *
     * @return string|null
     */
    public function getTypePrefix() {
        return null;
    }

    /**
     * Тип описания предложения. Значение должно быть vendor.model.
     *
     * @return string
     */
    public function getType() {
        return null;
    }
}
