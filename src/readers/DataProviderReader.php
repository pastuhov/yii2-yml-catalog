<?php

namespace pastuhov\ymlcatalog\readers;

use pastuhov\ymlcatalog\ReaderInterface;
use yii\base\Exception;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Класс выборки данных с помощью DataProvider.
 *
 * @package pastuhov\ymlcatalog\readers
 */
class DataProviderReader implements ReaderInterface
{
    /**
     * @var ActiveDataProvider|null
     */
    protected $dataProvider = null;

    /**
     * @var \yii\data\Pagination|boolean|null
     */
    protected $pagination = null;

    /**
     * @var Model[]|null
     */
    protected $models = null;

    /**
     * @inheritdoc
     *
     * @param ActiveDataProvider   $dataProvider
     */
    public function __construct(ActiveDataProvider $dataProvider = null)
    {
        if (is_null($dataProvider)) {
            throw new Exception('DataProvider can`t be empty.');
        }
        $this->dataProvider = $dataProvider;
        $this->pagination = $this->dataProvider->getPagination();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        if ($this->pagination && $this->pagination->getPage() != 0) {
            $this->pagination->setPage(0);
            $this->dataProvider->prepare(true);
        }
        $this->models = $this->dataProvider->getModels();
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        if ($this->pagination) {
            $this->pagination->setPage($this->pagination->getPage() + 1);
            $this->dataProvider->prepare(true);
            $this->models = $this->dataProvider->getModels();
        } else {
            $this->models = null;
        }
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return !empty($this->models);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->models;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        $key = 0;
        if ($this->pagination) {
            $key = $this->pagination->getPage();
        }
        return $key;
    }
}
