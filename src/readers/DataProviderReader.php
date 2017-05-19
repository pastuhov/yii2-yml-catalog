<?php

namespace pastuhov\ymlcatalog\readers;

use pastuhov\ymlcatalog\ReaderInterface;
use yii\base\Exception;
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
        if ($this->pagination->getPage() != 0) {
            $this->pagination->setPage(0);
            $this->dataProvider->prepare(true);
        }
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->pagination->setPage($this->pagination->getPage() + 1);
        $this->dataProvider->prepare(true);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return !empty($this->dataProvider->getModels());
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->dataProvider->getModels();
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->pagination->getPage();
    }
}
