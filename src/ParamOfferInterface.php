<?php

namespace pastuhov\ymlcatalog;

/**
 * Элемент param предназначен для описания характеристик и параметров товара.
 *
 * @link https://yandex.ru/support/partnermarket/param.html
 * @package pastuhov\yml
 */
interface ParamOfferInterface
{
    /**
     * Название параметра (обязательно).
     *
     * @return string
     */
    public function getName();

    /**
     * Значение параметра.
     *
     * @return string
     */
    public function getValue();

    /**
     * Единицы измерения (для числовых параметров, опционально).
     *
     * @return string
     */
    public function getUnit();
}
