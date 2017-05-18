<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 5/18/17
 * Time: 12:50 PM
 */

namespace pastuhov\ymlcatalog\categories\models\base;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use pastuhov\ymlcatalog\categories\models\Category as CategoryModel;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class Category extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ymlcatalog_categories';
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
                'value' => (new Expression('NOW()')),
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'full_name', 'ext_char_id', 'line_nbr'], 'required'],
            ['ymlcatalog_categorie_id', 'integer'],
            [
                'ymlcatalog_categorie_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => CategoryModel::className(),
                'targetAttribute' => ['ymlcatalog_categorie_id' => 'id'],
            ],

            // Для работы SaveRelationsBehavior.
            ['requestPositions', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created' => 'Создан',
            'updated' => 'Обновлён',
            'name' => 'Название',
            'full_name' => 'Полное название',
            'ymlcatalog_categorie_id' => 'Родитель',
            'ext_char_id' => 'Идентификатор Маркета',
            'line_nbr' => 'Номер строки в списке категорий Маркета',
        ];
    }

    public function getCategory()
    {
        return $this->hasMany(CategoryModel::className(), ['ymlcatalog_categorie_id' => 'id']);
    }
}