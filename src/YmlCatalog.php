<?php
namespace pastuhov\ymlcatalog;

use Yii;
use pastuhov\FileStream\BaseFileStream;

/**
 * Yml генератор каталога.
 *
 * @package pastuhov\ymlcatalog
 */
class YmlCatalog
{
    protected $handle;
    protected $shop;
    protected $category;
    protected $offer;
    protected $date;

    public function __construct(
        BaseFileStream $handle,
        ShopInterface $shop,
        $category,
        $offer,
        $date = null
    ) {
        $this->handle = $handle;
        $this->shop = $shop;
        $this->category = $category;
        $this->offer = $offer;
        $this->date = $date;
    }

    public function generate()
    {
        $date = $this->getDate();

        $this->handle->write(
            '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL .
            '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . PHP_EOL .
            '<yml_catalog date="' . $date . '">' . PHP_EOL
        );
        $this->handle->write('</yml_catalog>');
    }

    /**
     * @return null
     */
    public function getDate()
    {
        $date = $this->date;

        if ($date === null) {
            $date = Yii::$app->formatter->asDatetime(new \DateTime(), 'php:Y-m-d H:i');
        }

        return $date;
    }
}
