<?php
namespace pastuhov\ymlcatalog;

use pastuhov\ymlcatalog\models\BaseModel;
use pastuhov\ymlcatalog\models\Category;
use pastuhov\ymlcatalog\models\Currency;
use pastuhov\ymlcatalog\models\CustomOffer;
use pastuhov\ymlcatalog\models\Shop;
use pastuhov\ymlcatalog\models\SimpleOffer;
use pastuhov\ymlcatalog\models\DeliveryOption;
use Yii;
use pastuhov\FileStream\BaseFileStream;
use yii\base\Exception;
use yii\base\Object;
use yii\db\ActiveRecordInterface;

/**
 * Yml генератор каталога.
 *
 * @package pastuhov\ymlcatalog
 */
class YmlCatalog extends Object
{
    /**
     * @var BaseFileStream
     */
    public $handle;
    /**
     * @var string
     */
    public $shopClass;
    /**
     * @var string
     */
    public $currencyClass;
    /**
     * @var string
     */
    public $categoryClass;
    /**
     * @var string
     */
    public $offerClasses;
    /**
     * @var null|string
     */
    public $date;

    /**
     * @var null|callable
     */
    public $onValidationError;

    /**
     * @var null|string
     */
    public $customOfferClass;

    /**
     * @var null|string
     */
    public $deliveryOptionClass;

    /**
     * @throws Exception
     */
    public function generate()
    {
        $date = $this->getFormattedDate();

        $this->write(
            '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL .
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
        if($this->deliveryOptionClass) {
            $this->writeTag('delivery-options');
            $this->writeModel(new DeliveryOption(), \Yii::createObject($this->deliveryOptionClass));
            $this->writeTag('/delivery-options');
        }
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
    protected function getFormattedDate()
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
     * @param BaseModel $model
     * @param $valuesModel
     * @throws Exception
     */
    protected function writeModel(BaseModel $model, $valuesModel)
    {
        if($model->loadModel($valuesModel, $this->onValidationError)) {
            $string = $model->getYml();
            $this->write($string);
        }
    }

    /**
     * @param string|array $modelClass class name
     */
    protected function writeEachModel($modelClass)
    {
        $findParams = [];
        if (is_string($modelClass)) {
            $modelClass = ['class' => $modelClass];
        }

        if (array_key_exists('findParams', $modelClass)) {
            $findParams = $modelClass['findParams'];
            unset($modelClass['findParams']);
        }

        if (!is_subclass_of($modelClass['class'], ActiveRecordInterface::class)) {
            return $this->writeModel($this->getNewModel($modelClass), \Yii::createObject($modelClass));
        }

        $class = \Yii::createObject($modelClass);

        $newModel = $this->getNewModel($class);

        /* @var \yii\db\ActiveQuery $query */
        $query = $class::findYml($findParams);

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
        $obj = is_object($modelClass) ? $modelClass : \Yii::createObject($modelClass);

        if ($obj instanceof CurrencyInterface) {
            $model = new Currency();
        } elseif ($obj instanceof CategoryInterface) {
            $model = new Category();
        } elseif ($obj instanceof CustomOfferInterface) {
            $model = new CustomOffer();
        } elseif ($obj instanceof SimpleOfferInterface) {
            $model = new SimpleOffer();
        } else {
            throw new Exception('Model ' . get_class($obj) . ' has unknown interface');
        }

        return $model;
    }
}
