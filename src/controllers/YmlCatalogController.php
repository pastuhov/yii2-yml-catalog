<?php
namespace pastuhov\ymlcatalog\controllers;

use pastuhov\FileStream\BaseFileStream;
use yii\console\Controller;

class YmlCatalogController extends Controller
{
    /**
     * @var string
     */
    public $fileName = 'yml.xml';

    /**
     * @var bool
     */
    public $enableGzip = true;

    /**
     * @var string
     */
    public $publicPath;

    /**
     * @var string
     */
    public $runtimePath;

    /**
     * @var string
     */
    public $shopClass;

    /**
     * @var string
     */
    public $categoryClass;

    /**
     * @var string|string[]
     */
    public $offerClass;

    /**
     * @var \pastuhov\FileStream\BaseFileStream
     */
    protected $handler;

    public function actionGenerate()
    {
        $fileName = \Yii::getAlias($this->runtimePath) . '/' . $this->fileName;
        $this->handler = new BaseFileStream($fileName);

        return 'OK';
    }
}