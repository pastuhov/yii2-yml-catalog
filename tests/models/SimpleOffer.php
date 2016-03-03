<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\SimpleOfferInterface;
use yii\db\ActiveRecord;

/**
 * @inheritdoc
 */
class SimpleOffer extends ActiveRecord implements SimpleOfferInterface
{

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
    public function getOldPrice()
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
    public function getMarket_Category()
    {
        return null;
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
        return 'true';
    }

    /**
     * @inheritdoc
     */
    public function getLocal_Delivery_Cost()
    {
        return null;
    }

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
    public function getSales_Notes()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getManufacturer_Warranty()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getCountry_Of_Origin()
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
    public static function findYml($params = [])
    {
        $query = self::find();
        $query->orderBy('id');
        if (isset ($params['excluded'])) {
            $query->andWhere(['not in', 'id', $params['excluded']]);
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
}
