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
            $gzipedFileName = $fileName . '.gz';

            Command::exec($this->gzipCommand, [
                'src' => $fileName,
                'dst' => $gzipedFileName
            ]);

            $fileName = $gzipedFileName;
        }

        $publicPath = \Yii::getAlias($this->publicPath);
        rename($fileName, $publicPath . '/' . basename($fileName));

        Yii::endProfile('yml generate');

        return Controller::EXIT_CODE_NORMAL;
    }
}
