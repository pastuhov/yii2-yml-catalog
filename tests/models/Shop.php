<?php
namespace pastuhov\ymlcatalog\Test\models;

use pastuhov\ymlcatalog\ShopInterface;

/**
 * @inheritdoc
 */
class Shop implements ShopInterface
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'BestShop';
    }

    /**
     * @inheritdoc
     */
    public function getCompany()
    {
        return 'Best online seller Inc.';
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return 'http://best.seller.ru/';
    }

    /**
     * @inheritdoc
     */
    public function getPlatform()
    {
        return 'CMS';
    }

    /**
     * @inheritdoc
     */
    public function getVersion()
    {
        return '2.3';
    }

    /**
     * @inheritdoc
     */
    public function getAgency()
    {
        return 'Agency';
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return 'CMS@CMS.ru';
    }

    /**
     * @inheritdoc
     */
    public function getCpa()
    {
        return '1';
    }
}