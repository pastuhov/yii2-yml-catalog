<?php
namespace pastuhov\ymlcatalog\controllers;

use yii\console\Controller;

class YmlCatalogController extends Controller
{
    public $fileName;
    public $enableGzip = true;
    public $publicDir;
}