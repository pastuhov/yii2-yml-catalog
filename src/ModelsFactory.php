<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 5/17/17
 * Time: 5:58 PM
 */

namespace pastuhov\ymlcatalog;

use yii\base\Exception;
use yii\base\Object;
use pastuhov\ymlcatalog\models\BaseModel;
use pastuhov\ymlcatalog\models\Category;
use pastuhov\ymlcatalog\models\Currency;
use pastuhov\ymlcatalog\models\CustomOffer;
use pastuhov\ymlcatalog\models\Shop;
use pastuhov\ymlcatalog\models\SimpleOffer;
use pastuhov\ymlcatalog\models\DeliveryOption;

class ModelsFactory extends Object
{
    public $modelClass = null;
    public function create() {
        $interfacesClasses = [
            CurrencyInterface::class => Currency::class,
            CategoryInterface::class => Category::class,
            CustomOfferInterface::class => CustomOffer::class,
            SimpleOfferInterface::class => SimpleOffer::class,
            ShopInterface::class => Shop::class,
            DeliveryOptionInterface::class => DeliveryOption::class,
        ];

        $model = false;
        foreach ($interfacesClasses as $interfacesClass => $class) {
            $interfaces = class_implements($this->modelClass);
            if (isset($interfaces[$interfacesClass])) {
                $model = new $class;
                break;
            }
        }

        if (!$model) {
            throw new Exception('Instance ' . $this->modelClass . ' is not haved YML model interface\'');
        }

        return $model;
    }
}