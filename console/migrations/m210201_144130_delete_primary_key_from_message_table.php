<?php

use yii\db\Migration;

/**
 * Class m210201_144130_delete_primary_key_from_message_table
 */
class m210201_144130_delete_primary_key_from_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'message_ibfk_2',
            'message'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210201_144130_delete_primary_key_from_message_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210201_144130_delete_primary_key_from_message_table cannot be reverted.\n";

        return false;
    }
    */
}
