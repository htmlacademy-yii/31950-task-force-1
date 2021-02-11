<?php

use yii\db\Migration;

/**
 * Class m210210_175544_add_foreign_key_for_user_and_file_table
 */
class m210210_175544_add_foreign_key_for_user_and_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-user_file-user_id',
            'user_file',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_file-user_id',
            'user_file',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user_file-user_id',
            'user_file'
        );

        $this->dropIndex(
            'idx-user_file-user_id',
            'user_file'
        );

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210210_175544_add_foreign_key_for_user_and_file_table cannot be reverted.\n";

        return false;
    }
    */
}
