<?php
namespace pastuhov\ymlcatalog;

/**
 * Интерфейс для моделей, у которых необходимо преобразовывать запрещенные символы в значениях атрибутов в html-сущности
 * согласно требованиям Яндекс Маркета
 *
 * @package pastuhov\yml
 */
interface EscapedAttributes
{
    /**
     * Возвращает список атрибутов для преобразования
     *
     * @return string[]
     */
    public function getEscapedAttributes();
}
