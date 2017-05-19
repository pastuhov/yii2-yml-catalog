<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 5/19/17
 * Time: 11:59 AM
 */

namespace pastuhov\ymlcatalog\actions;


use yii\base\Action;

class DownloadAction extends Action
{
    public $fileName = null;
    public $publicPath = null;

    public function run() {
        $file = \yii::getAlias($this->publicPath) . '/' . $this->fileName;
        $response = \Yii::$app->getResponse();
        $response->setDownloadHeaders($this->fileName, mime_content_type($file));

        $response->sendContentAsFile(file_get_contents($file), $this->fileName);

        return $response;
    }
}