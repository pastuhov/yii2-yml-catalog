<?php
namespace pastuhov\ymlcatalog;

/**
 * Товарная категория.
 *
 * @package pastuhov\ymlcatalog
 */
interface CategoryInterface
{
    /**
     * Название категории.
     *
     * @return string
     */
    public function getName();

    /**
     * Идентификатор более высокой по иерархии (родительской) категории товаров.
     *
     * Если элемент <parentId> не указан, то категория считается корневой.
     *
     * @return int|null
     */
    public function getParentId();
}
