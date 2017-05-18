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

        $tags = [
            'shop' => [
                $this->shopClass,
                'currencies' => [
                    $this->currencyClass,
                ],
                'categories' => [
                    $this->categoryClass,
                ],
                'delivery-options' => [
                    $this->deliveryOptionClass,
                ],
                'offers' => $this->offerClasses,
            ],
        ];

        $this->parseTags($tags);

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

        $interfaces = class_implements($modelClass['class']);
        if (!isset($interfaces[ActiveRecordInterface::class])) {
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
        if (is_array($modelClass)) {
            $modelClass = $modelClass['class'];
        }

        $factory = new ModelsFactory([
            'modelClass' => $modelClass,
        ]);

        return $factory->create();
    }

    protected function parseTags($tags): void
    {
        foreach ($tags as $tagName => $tagParams) {
            if (is_string($tagName)) {
                $this->writeTag($tagName);
                $this->parseTags($tagParams);
                $this->writeTag('/' . $tagName);
            } else if (!is_null($tagParams)) {
                $this->writeEachModel($tagParams);
            }
        }
    }
}
