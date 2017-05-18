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
    public $categoryClass;

    /**
     * @var string[]
     */
    public $offerClass;

    /**
     * @var string
     */
    public $customOfferClass;

    /**
     * @var string
     */
    public $deliveryOptionClass;

    /**
     * @var callable
     */
    public $onValidationError;

    /**
     * @var string
     */
    public $handleClass = 'pastuhov\FileStream\BaseFileStream';

    /**
     * @var string
     */
    public $gzipCommand = 'gzip -f {keep_src} {src}';

    /**
     * Генерация YML.
     */
    public function run()
    {
        Yii::beginProfile('yml generate');

        $fileName = \Yii::getAlias($this->runtimePath) . DIRECTORY_SEPARATOR . $this->fileName;
        $handle = new $this->handleClass($fileName);

        $generatorAttributes = [
            'shopClass',
            'currencyClass',
            'categoryClass',
            'offerClass',
            'onValidationError',
            'deliveryOptionClass'
        ];
        $generatorParams = [
            'handle' => $handle,
        ];
        foreach ($generatorAttributes as $attribute) {
            $generatorParams[$attribute] = $this->$attribute;
        }
        $generator = new YmlCatalog($generatorParams);
        $generator->generate();

        if ($this->enableGzip === true) {
            Command::exec($this->gzipCommand, [
                'src' => $fileName,
                'keep_src' => $this->keepBoth ? '-k' : ''
            ]);
        }

        $publicPath = \Yii::getAlias($this->publicPath);
        if (!$this->enableGzip || $this->keepBoth) {
            rename($fileName, $publicPath . DIRECTORY_SEPARATOR . basename($fileName));
        }
        if ($this->enableGzip) {
            $fileName .= '.gz';
            rename($fileName, $publicPath . DIRECTORY_SEPARATOR . basename($fileName));
        }
        Yii::endProfile('yml generate');

        return Controller::EXIT_CODE_NORMAL;
    }
}
