<?php
namespace pastuhov\ymlcatalog\actions;

use Yii;
use pastuhov\Command\Command;
use pastuhov\ymlcatalog\YmlCatalog;
use yii\base\Action;
use yii\console\Controller;

/**
 * Генерация YML.
 *
 * @package pastuhov\ymlcatalog\actions
 */
class GenerateAction extends Action
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
     * Publish yml and .gz
     * 
     * @var bool
     */
    public $keepBoth = false;

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
    public $currencyClass;

    /**
     * @var string
     */
    public $localDeliveryCostClass;

    /**
     * @var string
     */
    public $categoryClass;

    /**
     * @var string[]
     */
    public $offerClasses;

    /**
     * @var string
     */
    public $handleClass = 'pastuhov\FileStream\BaseFileStream';

    /**
     * @var string
     */
    public $gzipCommand = 'cat {src} | gzip > {dst}';

    /**
     * Генерация YML.
     */
    public function run()
    {
        Yii::beginProfile('yml generate');

        $fileName = \Yii::getAlias($this->runtimePath) . '/' . $this->fileName;
        $gzipedFileName = $fileName . '.gz';
        $handle = new $this->handleClass($fileName);

        $generator = new YmlCatalog(
            $handle,
            $this->shopClass,
            $this->currencyClass,
            $this->categoryClass,
            $this->localDeliveryCostClass,
            $this->offerClasses
        );
        $generator->generate();

        if ($this->enableGzip === true) {
            Command::exec($this->gzipCommand, [
                'src' => $fileName,
                'dst' => $gzipedFileName
            ]);
            if (!$this->keepBoth) {
                $fileName = $gzipedFileName;
            }
        }

        $publicPath = \Yii::getAlias($this->publicPath);
        rename($fileName, $publicPath . '/' . basename($fileName));
        if ($this->enableGzip && $this->keepBoth) {
            rename($gzipedFileName, $publicPath . '/' . basename($gzipedFileName));
        }
        Yii::endProfile('yml generate');

        return Controller::EXIT_CODE_NORMAL;
    }
}
