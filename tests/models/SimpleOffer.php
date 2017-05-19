<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\BaseFindYmlInterface;
use pastuhov\ymlcatalog\SimpleOfferInterface;
use yii\db\ActiveRecord;

/**
 * @inheritdoc
 */
class SimpleOffer extends ActiveRecord implements SimpleOfferInterface, BaseFindYmlInterface
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->attributes['name'];
    }

    /**
     * @inheritdoc
     */
    public function getVendor()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return 'http://magazin.ru/product_page.asp?pid=' . $this->attributes['id'];
    }

    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->attributes['price'];
    }

    /**
     * @inheritdoc
     */
    public function getOldprice()
    {
        return $this->attributes['old_price'];
    }

    /**
     * @inheritdoc
     */
    public function getCurrencyId()
    {
        return 'RUR';
    }

    /**
     * @inheritdoc
     */
    public function getCategoryId()
    {
        return $this->attributes['category_id'];
    }

    /**
     * @inheritdoc
     */
    public function getPictures()
    {
        $pictures = Picture::find()->andWhere(['item_id' => $this->getId()])->all();
        $result = [];
        foreach ($pictures as $picture) {
            $result[] = $picture->getUrl();
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getStore()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getPickup()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getDelivery()
    {
        if ($this->getId() != 12) {
            return 'true';
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function getVendorCode()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->attributes['description'];
    }

    /**
     * @inheritdoc
     */
    public function getSales_notes()
    {
        return $this->attributes['sales_notes'];
    }

    /**
     * @inheritdoc
     */
    public function getManufacturer_warranty()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getCountry_of_origin()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getAdult()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getAge()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getBarcode()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getCpa()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function findYml($findParams = [])
    {
        $query = self::find();
        $query->orderBy('id');
        if (isset ($findParams['excluded'])) {
            $query->andWhere(['not in', 'id', $findParams['excluded']]);
        }

        return $query;
    }

    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function getBid()
    {
        return 13;
    }

    /**
     * @inheritdoc
     */
    public function getCbid()
    {
        return 20;
    }

    /**
     * @inheritdoc
     */
    public function getAvailable()
    {
        if ($this->attributes['is_available']) {
            return 'true';
        }

        return 'false';
    }

    /**
     * @inheritdoc
     */
    public function getDeliveryOptions()
    {
        $options = [];
        // если id товарного предложения равен 12, то для теста возвращаем пустой массив опций
        if($this->getId() != 12) {
            $options = [
                [
                    'cost' => 123,
                    'days' => '2'
                ],
                [
                    'cost' => 100,
                    'days' => '1'
                ],
            ];
        }

        return $options;
    }

    /**
     * @inheritdoc
     */
    public function getModel()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getFee()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getOutlets()
    {
        if($this->getId() != 12) {
            return [];
        }
        return [
            [
                'id' => 1,
                'instock' => 20,
                'booking' => 'true',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function getMinQuantity()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getStepQuantity()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getExpiry()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getWeight()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getDimensionsValues()
    {
        if ($this->getId() != 12) {
            return [];
        }

        return [1, 2.1, 3.1];
    }

    /**
     * @inheritdoc
     */
    public function getDownloadable()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getGroup_id()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getRecValues()
    {
        if ($this->getId() != 12) {
            return [];
        }

        return [1,2,3];
    }
}
