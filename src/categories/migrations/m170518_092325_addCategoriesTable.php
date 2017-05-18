<?php
class m170518_092325_addCategoriesTable extends \yii\db\Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('ymlcatalog_categories', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string()->notNull(),
            'full_name' => $this->string()->notNull(),
            'line_nbr' => $this->integer()->unsigned(),
            'ext_char_id' => $this->string(32)->notNull()->unique(),
            'ymlcatalog_categorie_id' => $this->integer(),
            'created' => $this->dateTime()->defaultExpression('now()'),
            'updated' => $this->dateTime()
        ]);
        $this->addForeignKey('ymlcatalog_categories_ymlcatalog_categorie_id_fk', 'ymlcatalog_categories', 'ymlcatalog_categorie_id', 'ymlcatalog_categories', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('ymlcatalog_categories');
    }
}
