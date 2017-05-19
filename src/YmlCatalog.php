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
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

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
    public $offerClass;
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
                'currencies' => $this->currencyClass,
                'categories' => $this->categoryClass,
                'delivery-options' => $this->deliveryOptionClass,
                'offers' => $this->offerClass,
            ],
        ];

        $this->writeTags($tags);

        $this->write('</yml_catalog>');
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

    protected function writeTags($tags)
    {
        foreach ($tags as $tagName => $tagParams) {
            if (is_string($tagName)) {
                $this->writeTag($tagName);
                if (is_string($tagParams) || isset($tagParams['class'])) {
                    $this->writeEachModel($tagParams);
                } else {
                    $this->writeTags($tagParams);
                }

                $this->writeTag('/' . $tagName);
            } else if (!is_null($tagParams)) {
                $this->writeEachModel($tagParams);
            }
        }
    }

    /**
     * @param string|array $modelClass class name or yii configuration array. You can also set params:
     *      `findParams`:   array of additional find params;
     *      `query`:        ActiveQuery object to generate yml use already created object;
     *      `dataProvider`: ActiveDataProvider or true to generate yml with pagination;
     */
    protected function writeEachModel($modelClass)
    {

        /**
         * @var ActiveQuery
         */
        $query = null;

        /**
         * @var ActiveDataProvider
         */
        $dataProvider = null;

        /**
         * @var mixed
         */
        $findParams = [];
        if (is_array($modelClass)) {
            foreach (['findParams', 'query', 'dataProvider'] as $name) {
                if (array_key_exists($name, $modelClass)) {
                    $$name = $modelClass[$name];
                    unset($modelClass[$name]);
                }
            }

            $modelClass = $modelClass['class'];
        }

        $interfaces = class_implements($modelClass);
        if (!isset($interfaces[BaseFindYmlInterface::class])) {
            return $this->writeModel($this->getNewModel($modelClass), \Yii::createObject($modelClass));
        }

        /**
         * @var BaseFindYmlInterface $class
         */
        $class = \Yii::createObject($modelClass);

        /**
         * @var ReaderInterface
         */
        $reader = ReaderFactory::build(
            $class,
            $dataProvider,
            $query,
            $findParams
        );

        $newModel = $this->getNewModel($class);

        foreach ($reader as $models) {
            foreach ($models as $model) {
                $this->writeModel($newModel, $model);
            }
            $this->gc();
        }
    }

    /**
     * @param $modelClass
     * @return Category|Currency|SimpleOffer
     * @throws Exception
     */
    protected function getNewModel($modelClass)
    {
        $factory = new ModelsFactory([
            'modelClass' => $modelClass,
        ]);

        return $factory->create();
    }
    
    /**
     * Performs PHP memory garbage collection.
     */
    protected function gc()
    {
        if (!gc_enabled()) {
            gc_enable();
        }
        gc_collect_cycles();
    }
}
