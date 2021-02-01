<?php

use yii\db\Migration;

/**
 * Class m210124_131530_rename_date_add_column_to_message_table
 */
class m210124_131530_rename_date_add_column_to_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('message', 'date_add', 'published_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('message', 'published_at', 'date_add');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210124_131530_rename_date_add_column_to_message_table cannot be reverted.\n";

        return false;
    }
    */
}
