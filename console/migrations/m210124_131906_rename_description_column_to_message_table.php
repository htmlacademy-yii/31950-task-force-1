<?php

use yii\db\Migration;

/**
 * Class m210124_131906_rename_description_column_to_message_table
 */
class m210124_131906_rename_description_column_to_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('message', 'description', 'message');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('message', 'message', 'description');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210124_131906_rename_description_column_to_message_table cannot be reverted.\n";

        return false;
    }
    */
}
