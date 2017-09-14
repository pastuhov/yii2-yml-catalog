<?php
namespace pastuhov\ymlcatalog\Test\controllers;

use pastuhov\ymlcatalog\actions\GenerateAction;
use yii\console\Controller;

/**
 * Class GenerateController with CustomCategory
 *
 * @package pastuhov\ymlcatalog\Test\controllers
 */
class GenerateControllerWithCustomCategory extends Controller
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
                'categoryClass' => 'pastuhov\ymlcatalog\Test\models\CustomCategory',
                'deliveryOptionClass' => 'pastuhov\ymlcatalog\Test\models\DeliveryOption',
                'customCategoryClass' => 'pastuhov\ymlcatalog\Test\models\SatomCategoryClass',
                'offerClasses' => [
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
