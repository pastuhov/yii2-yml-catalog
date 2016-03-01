<?php
namespace pastuhov\ymlcatalog;

use pastuhov\ymlcatalog\models\BaseModel;
use pastuhov\ymlcatalog\models\Category;
use pastuhov\ymlcatalog\models\Currency;
use pastuhov\ymlcatalog\models\LocalDeliveryCost;
use pastuhov\ymlcatalog\models\Shop;
use pastuhov\ymlcatalog\models\SimpleOffer;
use Yii;
use pastuhov\FileStream\BaseFileStream;
use yii\base\Exception;

/**
 * Yml генератор каталога.
 *
 * @package pastuhov\ymlcatalog
 */
class YmlCatalog
{
    /**
     * @var BaseFileStream
     */
    protected $handle;
    /**
     * @var string
     */
    protected $shopClass;
    /**
     * @var string
     */
    protected $currencyClass;
    /**
     * @var string
     */
    protected $categoryClass;
    /**
     * @var string
     */
    protected $localDeliveryCostClass;
    /**
     * @var string
     */
    protected $offerClass;
    /**
     * @var null|string
     */
    protected $date;

    /**
     * @var null|callable
     */
    protected $onValidationError;

    /**
     * @param BaseFileStream $handle
     * @param string $shopClass class name
     * @param string $currencyClass class name
     * @param string $categoryClass class name
     * @param string $localDeliveryCostClass class name
     * @param array $offerClasses
     * @param null|string $date
     * @param null|callable $onValidationError
     */
    public function __construct(
        BaseFileStream $handle,
        $shopClass,
        $currencyClass,
        $categoryClass,
        $localDeliveryCostClass,
        Array $offerClasses,
        $date = null,
        $onValidationError = null
    ) {
        $this->handle = $handle;
        $this->shopClass = $shopClass;
        $this->currencyClass = $currencyClass;
        $this->categoryClass = $categoryClass;
        $this->localDeliveryCostClass = $localDeliveryCostClass;
        $this->offerClasses = $offerClasses;
        $this->date = $date;
        $this->onValidationError = $onValidationError;
    }

    /**
     * @throws Exception
     */
    public function generate()
    {
        $date = $this->getDate();

        $this->write(
            '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL .
            '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . PHP_EOL .
            '<yml_catalog date="' . $date . '">' . PHP_EOL
        );

        $this->writeTag('shop');
        $this->writeModel(new Shop(), new $this->shopClass());
        $this->writeTag('currencies');
        $this->writeEachModel($this->currencyClass);
        $this->writeTag('/currencies');
        $this->writeTag('categories');
        $this->writeEachModel($this->categoryClass);
        $this->writeTag('/categories');
        $this->writeModel(new LocalDeliveryCost(), new $this->localDeliveryCostClass());
        $this->writeTag('offers');
        foreach ($this->offerClasses as $offerClass) {
            $this->writeEachModel($offerClass);
        }
        $this->writeTag('/offers');
        $this->writeTag('/shop');

        $this->write('</yml_catalog>');
    }

    /**
     * @return null|string
     */
    protected function getDate()
    {
        $date = $this->date;

        if ($date === null) {
            $date = Yii::$app->formatter->asDatetime(new \DateTime(), 'php:Y-m-d H:i');
        }

        return $date;
    }

    /**
     * @param string $string
     * @throws \Exception
     */
    protected function write($string)
    {
        $this->handle->write($string);
    }

    /**
     * @param string $string tag name
     */
    protected function writeTag($string)
    {
        $this->write('<' . $string . '>' . PHP_EOL);
    }

    /**
     * @param BaseModel $model model
     * @param $valuesModel
     * @throws Exception
     */
    protected function writeModel(BaseModel $model, $valuesModel)
    {
        $attributes = [];
        foreach ($model->attributes() as $attribute) {
            $methodName = 'get' . ucfirst($attribute);
            $attributeValue = $valuesModel->$methodName();

            $attributes[$attribute] = $attributeValue;
        }

        $model->load($attributes, '');
        if (method_exists($valuesModel, 'getParams')) {
            $model->setParams($valuesModel->getParams());
        }
        if (method_exists($valuesModel, 'getPictures')) {
            $model->setPictures($valuesModel->getPictures());
        }

        if (!$model->validate()) {
            if (is_callable($onValidationError = $this->onValidationError)) {
                $onValidationError($model);
            } else {
                throw new Exception('Model values is invalid ' . serialize($model->getErrors()));
            }
        }

        $string = $model->getYml();

        $this->write($string);
    }

    /**
     * @param string $modelClass class name
     */
    protected function writeEachModel($modelClass)
    {
        $newModel = $this->getNewModel($modelClass);

        /* @var \yii\db\ActiveQuery $query */
        $query = $modelClass::findYml();

        foreach ($query->batch(100) as $models) {
            foreach ($models as $model) {
                $this->writeModel($newModel, $model);
            }
        }
    }

    /**
     * @param $modelClass
     * @return Category|Currency|SimpleOffer
     * @throws Exception
     */
    protected function getNewModel($modelClass)
    {
        $obj = new $modelClass();

        if ($obj instanceof CurrencyInterface) {
            $model = new Currency();
        } elseif ($obj instanceof CategoryInterface) {
            $model = new Category();
        } elseif ($obj instanceof SimpleOfferInterface) {
            $model = new SimpleOffer();
        } else {
            throw new Exception('Model ' . $modelClass. ' has unknown interface');
        }

        return $model;
    }
}
