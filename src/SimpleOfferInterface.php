<?php
namespace pastuhov\ymlcatalog;

/**
 * Простое товарное предложение.
 *
 * @link https://yandex.st/market-export/1.0-17/partner/help/YML.xml
 * @package pastuhov\ymlcatalog
 */
interface SimpleOfferInterface extends OfferInterface
{
    /**
     * Название товарного предложения.
     *
     * В названии упрощенного предложения рекомендуется указывать
     * наименование и код производителя.
     * Тип или категория товара, производитель или бренд, модель товара и важные параметры
     *
     * Обязательный элемент.
     *
     * @return string
     */
    public function getName();

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
}
