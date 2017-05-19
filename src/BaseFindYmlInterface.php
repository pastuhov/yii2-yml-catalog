<?php
namespace pastuhov\ymlcatalog;

use yii\db\ActiveRecordInterface;

/**
 * Базовый интерфейс поиска данных, для генерации yml.
 *
 * @package pastuhov\ymlcatalog
 */
interface BaseFindYmlInterface extends ActiveRecordInterface
{
    /**
     * Идентификатор записи.
     *
     * Идентификатор записи должен быть уникальным положительным целым числом большим 0.
     *
     * @return int
     */
    public function getId();

    /**
     * @param array $findParams Массив дополнительных параметров для поиска.
     *
     * @return \yii\db\ActiveQuery
     */
    public static function findYml($findParams = []);
}
