<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 5/18/17
 * Time: 11:33 AM
 */

namespace pastuhov\ymlcatalog\categories\controllers;


use pastuhov\ymlcatalog\categories\models\Category;
use pastuhov\ymlcatalog\categories\SourceToArrayConverter;
use yii\base\Exception;
use yii\console\Controller;

class ConvertController extends Controller
{
    public function actionToArray() {
        $arrayResult = $this->convertSource();
        $config = str_replace('  ', '    ', str_replace(')', ']', str_replace(["\n" . '  array (', 'array ('], '[', var_export($arrayResult, true))));
        $result = <<<PHP
<?php
return $config;
PHP;

        file_put_contents(__DIR__ . '/../data/categories.php', $result);
    }

    public function actionToDatabase() {
        $arrayResults = $this->convertSource();
        foreach ($arrayResults as $arrayResult) {
            $category = Category::findOrCreate($arrayResult);
            if (!$category->save()) {
                throw new Exception('Failed save ' . var_export($category->attributes, true) . ' errors: ' . var_export($category->errors));
            }
        }
    }

    /**
     * @return array
     */
    protected function convertSource()
    {
        $source = file_get_contents(__DIR__ . '/../data/categories.csv');
        $converter = new SourceToArrayConverter([
            'source' => $source,
        ]);
        $arrayResult = $converter->convert();
        return $arrayResult;
    }
}