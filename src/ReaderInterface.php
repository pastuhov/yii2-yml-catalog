<?php

namespace pastuhov\ymlcatalog;

/**
 * Базовый интерфейс для выборки данных из базы.
 *
 * @package pastuhov\ymlcatalog
 */
interface ReaderInterface extends \Iterator
{
    /**
     * @var int Количество записей в странице выборки.
     */
    const DEFAULT_PAGE_SIZE = 100;

    /**
     * Создание reader-а с указанным источником данных.
     */
    public function __construct();
}
