<?php
namespace pastuhov\ymlcatalog;

/**
 * Товарное предложение.
 *
 * @link https://yandex.st/market-export/1.0-17/partner/help/YML.xml
 * @package pastuhov\yml
 */
interface CustomOfferInterface extends OfferInterface
{
    /**
     * Модель и важные параметры. В некоторых категориях для привязки предложения к карточке помимо модели необходимо
     * передавать другие важные параметры товара, например «iPhone 6s 128gb розовое золото», «Sureste-N 150x70».
     *
     * @return string
     */
    public function getModel();

    /**
     * Производитель.
     *
     * Не отображается в названии предложения.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getVendor();

    /**
     * Код товара (указывается код производителя).
     *
     * Не отображается в названии предложения.
     * Необязательный элемент.
     *
     * @return string|null
     */
    public function getVendorCode();

    /**
     * Тип / категория товара (например, «мобильный телефон», «стиральная машина», «угловой диван»).
     *
     * @return string|null
     */
    public function getTypePrefix();

    /**
     * Тип описания предложения. Значение должно быть vendor.model.
     *
     * @return string
     */
    public function getType();
}
