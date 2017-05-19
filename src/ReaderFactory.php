<?php

namespace pastuhov\ymlcatalog;

use pastuhov\ymlcatalog\readers\DataProviderReader;
use pastuhov\ymlcatalog\readers\QueryReader;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class ReaderFactory
{
    /**
     * Reader Factory builder.
     *
     * @param BaseFindYmlInterface      $class
     * @param ActiveDataProvider|null   $dataProvider
     * @param ActiveQuery|null          $query
     * @param mixed                     $findParams
     *
     * @return ReaderInterface
     */
    public static function build(
        BaseFindYmlInterface $class,
        ActiveDataProvider $dataProvider = null,
        ActiveQuery $query = null,
        $findParams = []
    )
    {
        if (!empty($dataProvider)) {
            if ($dataProvider instanceof ActiveDataProvider) {
                $reader = new DataProviderReader($dataProvider);
            } elseif ($dataProvider === true) {
                if (!$query) {
                    $query = $class::findYml($findParams);
                }
                $reader = new DataProviderReader(
                    new ActiveDataProvider([
                        'query' => $query,
                        'pagination' => [
                            'pageSize' => 1000,
                        ]
                    ])
                );
            }
        }

        if (empty($reader)) {
            $reader = new QueryReader($query ? : $class::findYml($findParams));
        }

        return $reader;
    }
}
