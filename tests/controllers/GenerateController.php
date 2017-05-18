<?php
namespace pastuhov\ymlcatalog\Test\controllers;

use pastuhov\ymlcatalog\actions\GenerateAction;
use yii\console\Controller;

/**
 * Class GenerateController
 *
 * @package pastuhov\ymlcatalog\Test\controllers
 */
class GenerateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'generate' => [
                'class' => GenerateAction::className(),
                'enableGzip' => true,
                'fileName' => 'yml-test.xml',
                'publicPath' => '@runtime/public',
                'runtimePath' => '@runtime',
                'shopClass' => 'pastuhov\ymlcatalog\Test\models\Shop',
                'currencyClass' => 'pastuhov\ymlcatalog\Test\models\Currency',
                'categoryClass' => 'pastuhov\ymlcatalog\Test\models\Category',
                'deliveryOptionClass' => 'pastuhov\ymlcatalog\Test\models\DeliveryOption',
                'offerClass' => [
                    [
                        'class' => 'pastuhov\ymlcatalog\Test\models\SimpleOffer',
                        'findParams' => [
                            'excluded' => [
                                13
                            ]
                        ]
                    ]
                ],
                'onValidationError' => function () {

                }
            ],
        ];
    }
}