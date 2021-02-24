<?php

use yii\db\Migration;

/**
 * Class m210210_175336_create_table_for_user_and_file
 */
class m210210_175336_create_table_for_user_and_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_file', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'file' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_file');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210210_175336_create_table_for_user_and_file cannot be reverted.\n";

        return false;
    }
    */
}
