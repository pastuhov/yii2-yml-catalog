<?php
namespace pastuhov\ymlcatalog\controllers;

use pastuhov\Command\Command;
use pastuhov\ymlcatalog\YmlCatalog;
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
     * @var string
     */
    public $handleClass = 'pastuhov\FileStream\BaseFileStream';

    /**
     * @var string
     */
    public $gzipCommand = 'cat {src} | gzip > {dst}';

    public function actionGenerate()
    {
        $fileName = \Yii::getAlias($this->runtimePath) . '/' . $this->fileName;
        $handle = new $this->handleClass($fileName);

        $shopClass = $this->shopClass;

        $generator = new YmlCatalog(
            $handle,
            new $shopClass,
            $this->categoryClass,
            $this->offerClass
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

        return self::EXIT_CODE_NORMAL;
    }
}