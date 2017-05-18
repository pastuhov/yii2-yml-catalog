<?php

namespace pastuhov\ymlcatalog\readers;

use pastuhov\ymlcatalog\ReaderInterface;
use yii\base\Exception;
use yii\db\ActiveQuery;

/**
 * Класс выборки данных с помощью Query.
 *
 * @package pastuhov\ymlcatalog\readers
 */
class QueryReader implements ReaderInterface
{
    /**
     * @var ActiveQuery|null
     */
    protected $query = null;

    /**
     * @var null|\yii\db\BatchQueryResult
     */
    protected $iterator = null;

    /**
     * @inheritdoc
     *
     * @param ActiveQuery   $query
     * @param int           $pageSize
     */
    public function __construct(ActiveQuery $query = null, $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        if (is_null($query)) {
            throw new Exception('Query can`t be empty.');
        }

        $this->query = $query;
        $this->iterator = $this->query->batch($pageSize);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->iterator->rewind();
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->iterator->next();
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->iterator->valid();
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->iterator->key();
    }
}
