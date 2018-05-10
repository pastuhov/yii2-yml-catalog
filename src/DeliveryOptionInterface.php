<?php

namespace pastuhov\ymlcatalog;

/**
 * Стоимость и сроки курьерской доставки по своему региону.
 *
 * @link https://yandex.ru/support/partnermarket/elements/delivery-options.xml
 * @package pastuhov\yml
 */
interface DeliveryOptionInterface
{
    /**
     * Стоимость доставки в рублях.
     * Для указания бесплатной доставки используйте значение 0.
     *
     * @return int
     */
    public function getCost();

    /**
     * Срок доставки в рабочих днях.
     * Можно указать как конкретное количество дней, так и период «от — до». Например, срок доставки от 2 до 4 дней
     * описывается следующим образом: days="2-4".
     *
     * @return string
     */
    public function getDays();

    /**
     * Время, до которого нужно сделать заказ, чтобы получить его в этот срок.
     * Укажите местное время (в часовом поясе магазина), при заказе до которого действует срок доставки. В качестве
     * значения используйте только целое число от 0 до 24.
     *
     * @return int
     */
    public function getOrderBefore();
}
