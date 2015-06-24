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
        return 'Test';
    }

    /**
     * @inheritdoc
     */
    public function getCompany()
    {
        return 'Test ltd';
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return 'http://www.magazin.ru/';
    }

    /**
     * @inheritdoc
     */
    public function getPlatform()
    {
        return 'OtherCms';
    }

    /**
     * @inheritdoc
     */
    public function getVersion()
    {
        return '0.1';
    }

    /**
     * @inheritdoc
     */
    public function getAgency()
    {
        return 'Other Web Agency';
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
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
}